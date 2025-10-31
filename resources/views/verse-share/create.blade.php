<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px;">
        <div style="max-width: 1400px; margin: 0 auto;">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 style="font-size: 2.5rem; font-weight: bold; color: white; margin-bottom: 10px;">🎨 Create Verse Image</h1>
                <p style="font-size: 1.1rem; color: rgba(255, 255, 255, 0.9);">Design beautiful images to share your favorite verses</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Left: Controls -->
                <div>
                    <!-- Verse Info -->
                    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h3 style="font-size: 1.2rem; font-weight: bold; color: #1f2937; margin-bottom: 15px;">📖 {{ $verse->book }} {{ $verse->chapter }}:{{ $verse->verse }}</h3>
                        <p style="color: #6b7280; line-height: 1.7; font-style: italic;">"{{ $verse->text }}"</p>
                    </div>

                    <!-- Template Selection -->
                    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h3 style="font-size: 1.1rem; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Choose Template</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <button onclick="selectTemplate('gradient')" id="template-gradient" class="template-btn" style="padding: 20px; border: 3px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; cursor: pointer; transition: transform 0.2s;">
                                Gradient
                            </button>
                            <button onclick="selectTemplate('solid')" id="template-solid" class="template-btn" style="padding: 20px; border: 3px solid transparent; border-radius: 8px; background: #3b82f6; color: white; font-weight: 600; cursor: pointer; transition: transform 0.2s;">
                                Solid Color
                            </button>
                            <button onclick="selectTemplate('minimal')" id="template-minimal" class="template-btn" style="padding: 20px; border: 3px solid transparent; border-radius: 8px; background: #ffffff; color: #1f2937; font-weight: 600; cursor: pointer; border: 2px solid #e5e7eb; transition: transform 0.2s;">
                                Minimal
                            </button>
                            <button onclick="selectTemplate('elegant')" id="template-elegant" class="template-btn" style="padding: 20px; border: 3px solid transparent; border-radius: 8px; background: #1f2937; color: white; font-weight: 600; cursor: pointer; transition: transform 0.2s;">
                                Elegant Dark
                            </button>
                        </div>
                    </div>

                    <!-- Customization -->
                    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h3 style="font-size: 1.1rem; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Customize</h3>
                        
                        <!-- Font Size -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Font Size</label>
                            <select id="fontSize" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; outline: none;">
                                <option value="small">Small</option>
                                <option value="medium" selected>Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>

                        <!-- Background Color (for solid template) -->
                        <div id="bgColorSection" style="display: none; margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Background Color</label>
                            <input type="color" id="bgColor" value="#3b82f6" style="width: 100%; height: 50px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                        </div>

                        <!-- Text Color -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 8px;">Text Color</label>
                            <input type="color" id="textColor" value="#ffffff" style="width: 100%; height: 50px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button onclick="generateImage()" id="generateBtn" style="width: 100%; padding: 18px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        🎨 Generate Image
                    </button>
                </div>

                <!-- Right: Preview -->
                <div>
                    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: sticky; top: 20px;">
                        <h3 style="font-size: 1.1rem; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Preview</h3>
                        
                        <div id="preview" style="background: #f3f4f6; border-radius: 8px; min-height: 400px; display: flex; align-items: center; justify-content: center; color: #6b7280;">
                            <div style="text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 15px;">🎨</div>
                                <p>Select a template and click Generate</p>
                            </div>
                        </div>

                        <div id="downloadSection" style="display: none; margin-top: 20px;">
                            <a id="downloadLink" href="#" download style="display: block; width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';">
                                📥 Download Image
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedTemplate = 'gradient';

        function selectTemplate(template) {
            selectedTemplate = template;
            
            // Update button styles
            document.querySelectorAll('.template-btn').forEach(btn => {
                btn.style.border = '3px solid transparent';
            });
            document.getElementById('template-' + template).style.border = '3px solid #10b981';
            
            // Show/hide background color picker
            document.getElementById('bgColorSection').style.display = 
                template === 'solid' ? 'block' : 'none';
                
            // Update text color default
            if (template === 'minimal') {
                document.getElementById('textColor').value = '#1f2937';
            } else {
                document.getElementById('textColor').value = '#ffffff';
            }
        }

        function generateImage() {
            const btn = document.getElementById('generateBtn');
            btn.disabled = true;
            btn.textContent = '⏳ Generating...';

            const formData = new FormData();
            formData.append('template', selectedTemplate);
            formData.append('background_color', document.getElementById('bgColor').value);
            formData.append('text_color', document.getElementById('textColor').value);
            formData.append('font_size', document.getElementById('fontSize').value);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("verse-share.generate", $verse) }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show preview
                    document.getElementById('preview').innerHTML = 
                        `<img src="${data.image_url}" style="width: 100%; border-radius: 8px;">`;
                    
                    // Show download button
                    document.getElementById('downloadSection').style.display = 'block';
                    document.getElementById('downloadLink').href = data.image_url;
                    
                    btn.disabled = false;
                    btn.textContent = '✨ Regenerate Image';
                } else {
                    alert('Error generating image. Please try again.');
                    btn.disabled = false;
                    btn.textContent = '🎨 Generate Image';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating image. Please try again.');
                btn.disabled = false;
                btn.textContent = '🎨 Generate Image';
            });
        }
    </script>
</x-app-layout>
