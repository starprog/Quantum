<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    public function toggle(Module $module)
    {
        $module->enabled = !$module->enabled;
        $module->save();

        return redirect()->route('modules.index')->with('success',
            'Module ' . $module->name . ' has been ' . ($module->enabled ? 'enabled' : 'disabled'));
    }

    public function scan()
    {
        $modulesPath = base_path('modules');

        if (!is_dir($modulesPath)) {
            return redirect()->route('modules.index')->with('error', 'Modules directory not found');
        }

        $dirs = array_filter(glob($modulesPath . '/*'), 'is_dir');
        $scannedCount = 0;

        foreach ($dirs as $dir) {
            $moduleFile = $dir . '/module.php';
            if (file_exists($moduleFile)) {
                $config = include $moduleFile;

                if (!empty($config['name'])) {
                    $existing = Module::where('name', $config['name'])->first();

                    if (!$existing) {
                        Module::create([
                            'name' => $config['name'],
                            'path' => 'modules/' . basename($dir),
                            'provider' => $config['provider'] ?? null,
                            'enabled' => false,
                            'settings' => null,
                        ]);
                        $scannedCount++;
                    }
                }
            }
        }

        return redirect()->route('modules.index')->with('success',
            "Scanned modules directory. Found {$scannedCount} new modules.");
    }

    public function upload(Request $request)
    {
        $request->validate([
            'module_file' => 'required|file|mimes:zip|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('module_file');
            $modulesPath = base_path('modules');

            // Ensure modules directory exists
            if (!is_dir($modulesPath)) {
                mkdir($modulesPath, 0755, true);
            }

            // Create temporary directory for extraction
            $tempPath = storage_path('app/temp_module_' . time());
            mkdir($tempPath, 0755, true);

            // Move uploaded file to temp location
            $zipPath = $tempPath . '/module.zip';
            $file->move($tempPath, 'module.zip');

            // Extract zip file
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($tempPath);
                $zip->close();

                // Find the module directory (could be nested)
                $extractedItems = glob($tempPath . '/*');
                $moduleDir = null;

                foreach ($extractedItems as $item) {
                    if (is_dir($item) && $item !== $zipPath) {
                        // Check if this directory contains a module.php file
                        if (file_exists($item . '/module.php')) {
                            $moduleDir = $item;
                            break;
                        }
                    }
                }

                // If no direct module.php found, check if module.php is in the temp root
                if (!$moduleDir && file_exists($tempPath . '/module.php')) {
                    $moduleDir = $tempPath;
                }

                if (!$moduleDir) {
                    // Clean up
                    File::deleteDirectory($tempPath);
                    return redirect()->route('modules.index')->with('error', 'Invalid module: module.php not found in zip file.');
                }

                // Read module config to get module name
                $config = include $moduleDir . '/module.php';
                if (empty($config['name'])) {
                    File::deleteDirectory($tempPath);
                    return redirect()->route('modules.index')->with('error', 'Invalid module: module name not specified in module.php.');
                }

                $moduleName = $config['name'];
                $finalModulePath = $modulesPath . '/' . ucfirst($moduleName);

                // Check if module already exists
                if (is_dir($finalModulePath)) {
                    File::deleteDirectory($tempPath);
                    return redirect()->route('modules.index')->with('error', "Module '{$moduleName}' already exists.");
                }

                // Move module to final location
                if ($moduleDir === $tempPath) {
                    // Files are in temp root, move them to new module directory
                    mkdir($finalModulePath, 0755, true);
                    $files = glob($tempPath . '/*');
                    foreach ($files as $file) {
                        if (basename($file) !== 'module.zip') {
                            $dest = $finalModulePath . '/' . basename($file);
                            if (is_dir($file)) {
                                File::copyDirectory($file, $dest);
                            } else {
                                copy($file, $dest);
                            }
                        }
                    }
                } else {
                    // Module is in a subdirectory, move the whole directory
                    rename($moduleDir, $finalModulePath);
                }

                // Clean up temp directory
                File::deleteDirectory($tempPath);

                // Auto-register the module in database
                $existingModule = Module::where('name', $moduleName)->first();
                if (!$existingModule) {
                    Module::create([
                        'name' => $moduleName,
                        'path' => 'modules/' . ucfirst($moduleName),
                        'provider' => $config['provider'] ?? null,
                        'enabled' => false, // Start disabled for safety
                        'settings' => null,
                    ]);
                }

                return redirect()->route('modules.index')->with('success', "Module '{$moduleName}' uploaded and installed successfully!");

            } else {
                File::deleteDirectory($tempPath);
                return redirect()->route('modules.index')->with('error', 'Failed to extract zip file.');
            }

        } catch (\Exception $e) {
            // Clean up on error
            if (isset($tempPath) && is_dir($tempPath)) {
                File::deleteDirectory($tempPath);
            }
            return redirect()->route('modules.index')->with('error', 'Error uploading module: ' . $e->getMessage());
        }
    }
}
