<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1024px; margin: 0 auto; padding: 3rem 1.5rem;">
            
            <!-- Hero Section -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3.5rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    ⚙️ Settings
                </h1>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Customize your experience and manage your preferences
                </p>
            </div>

            <div style="display: grid; gap: 2rem;"
                <!-- Notification Settings -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                    border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Notification Preferences</h3>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox" checked
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">📧 Email notifications for daily verses</span>
                        </label>
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox"
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">🔔 Push notifications for new features</span>
                        </label>
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox" checked
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">📊 Weekly activity summary</span>
                        </label>
                    </div>
                </div>

                <!-- Theme Settings -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); 
                                    border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Theme & Display</h3>
                    </div>
                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                🎨 Theme Mode
                            </label>
                            <select style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; 
                                          font-size: 1rem; background: white; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                                <option>☀️ Light Mode</option>
                                <option>🌙 Dark Mode</option>
                                <option>🔄 Auto (System)</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                🌍 Language
                            </label>
                            <select style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; 
                                          font-size: 1rem; background: white; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                                <option>English</option>
                                <option>Español</option>
                                <option>Français</option>
                                <option>Deutsch</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                📖 Default Bible Translation
                            </label>
                            <select style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; 
                                          font-size: 1rem; background: white; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                                <option>King James Version (KJV)</option>
                                <option>New International Version (NIV)</option>
                                <option>English Standard Version (ESV)</option>
                                <option>New Living Translation (NLT)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                                    border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Security & Privacy</h3>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: center; justify-between; padding: 1rem; border-radius: 0.5rem; 
                                    border: 2px solid #f3f4f6; transition: all 0.2s;"
                             onmouseover="this.style.borderColor='#667eea'; this.style.background='#f9fafb'"
                             onmouseout="this.style.borderColor='#f3f4f6'; this.style.background='transparent'">
                            <div>
                                <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem;">🔐 Two-Factor Authentication</h4>
                                <p style="font-size: 0.875rem; color: #6b7280;">Add an extra layer of security to your account</p>
                            </div>
                            <a href="{{ route('profile.show') }}" 
                               style="padding: 0.5rem 1.25rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                      color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                                      white-space: nowrap; transition: all 0.2s;"
                               onmouseover="this.style.opacity='0.9'"
                               onmouseout="this.style.opacity='1'">
                                Configure
                            </a>
                        </div>
                        <div style="display: flex; align-items: center; justify-between; padding: 1rem; border-radius: 0.5rem; 
                                    border: 2px solid #f3f4f6; transition: all 0.2s;"
                             onmouseover="this.style.borderColor='#667eea'; this.style.background='#f9fafb'"
                             onmouseout="this.style.borderColor='#f3f4f6'; this.style.background='transparent'">
                            <div>
                                <h4 style="font-weight: 600; color: #1f2937; margin-bottom: 0.25rem;">🔑 Password</h4>
                                <p style="font-size: 0.875rem; color: #6b7280;">Last changed 30 days ago</p>
                            </div>
                            <a href="{{ route('profile.show') }}" 
                               style="padding: 0.5rem 1.25rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                      color: white; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
                                      white-space: nowrap; transition: all 0.2s;"
                               onmouseover="this.style.opacity='0.9'"
                               onmouseout="this.style.opacity='1'">
                                Change
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div style="background: white; border-radius: 1rem; padding: 2rem; 
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
                                    border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 1.25rem; height: 1.25rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Advanced Options</h3>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox"
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">🐛 Enable debug mode</span>
                        </label>
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox"
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">🧪 Allow beta features</span>
                        </label>
                        <label style="display: flex; align-items: center; padding: 0.75rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;"
                               onmouseover="this.style.background='#f3f4f6'"
                               onmouseout="this.style.background='transparent'">
                            <input type="checkbox"
                                   style="width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; border: 2px solid #667eea; 
                                          cursor: pointer; accent-color: #667eea;">
                            <span style="margin-left: 0.75rem; color: #374151; font-weight: 500;">📊 Analytics & usage data</span>
                        </label>
                    </div>
                </div>

                <!-- Save Button -->
                <div style="text-align: center; margin-top: 2rem;">
                    <button type="button" 
                            style="padding: 1rem 3rem; background: white; color: #667eea; 
                                   border: 3px solid white; border-radius: 0.75rem; font-weight: 700; font-size: 1.125rem;
                                   cursor: pointer; transition: all 0.2s; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);"
                            onmouseover="this.style.background='linear-gradient(135deg, #667eea 0%, #764ba2 100%)'; this.style.color='white'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)'"
                            onmouseout="this.style.background='white'; this.style.color='#667eea'; this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'">
                        💾 Save All Settings
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
