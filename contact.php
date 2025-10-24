<?php
$pageTitle = 'Contact - World Recipes';
$currentPage = 'contact';

// Handle form submission (PUBLIC - no login required)
$messageSent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields.';
    } elseif (strlen($name) > 100) {
        $error = 'Name must be less than 100 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($message) < 10) {
        $error = 'Message must be at least 10 characters long.';
    } elseif (strlen($message) > 1000) {
        $error = 'Message must be less than 1000 characters.';
    } else {
        // In a real application, you would send the email here
        // For this demo, we'll just show a success message
        $messageSent = true;
        
        // Optional: Log the contact form submission
        error_log("Contact form submission: " . sanitizeOutput($name) . " (" . sanitizeOutput($email) . ") - " . sanitizeOutput($subject));
    }
}

include 'includes/header.php';
?>

<main class="container">
    <section class="contact-hero">
        <h1>Contact Us</h1>
        <p class="lead">We'd love to hear from you! Get in touch with questions, suggestions, or recipe submissions.</p>
    </section>

    <div class="contact-content">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p>Have a question about a recipe? Want to suggest a new dish from your country? Or just want to share your cooking experience? We're here to help!</p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-icon">📧</div>
                        <div>
                            <h3>Email</h3>
                            <p>hello@worldrecipes.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-icon">🌍</div>
                        <div>
                            <h3>Website</h3>
                            <p>www.worldrecipes.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="contact-icon">📱</div>
                        <div>
                            <h3>Social Media</h3>
                            <p>Follow us for daily recipe inspiration</p>
                        </div>
                    </div>
                </div>

                <div class="faq-section">
                    <h3>Frequently Asked Questions</h3>
                    <div class="faq-item">
                        <h4>Can I submit my own recipes?</h4>
                        <p>Yes! We're always looking for authentic recipes from around the world. Use the contact form to tell us about your recipe.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Are the recipes tested?</h4>
                        <p>All our recipes are sourced from reputable cooking websites and traditional sources to ensure authenticity and quality.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Can I print the recipes?</h4>
                        <p>Absolutely! Each recipe page has a print button for easy printing.</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-section">
                <?php if ($messageSent): ?>
                    <div class="success-message">
                        <h3>✅ Message Sent!</h3>
                        <p>Thank you for contacting us. We'll get back to you soon!</p>
                        <a href="contact.php" class="btn-secondary">Send Another Message</a>
                    </div>
                <?php else: ?>
                    <h2>Send us a Message</h2>
                    
                    <?php if ($error): ?>
                        <div class="error-message">
                            <p><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact-form">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" name="subject" required>
                                <option value="">Choose a topic...</option>
                                <option value="Recipe Question" <?php echo ($_POST['subject'] ?? '') === 'Recipe Question' ? 'selected' : ''; ?>>Recipe Question</option>
                                <option value="Recipe Submission" <?php echo ($_POST['subject'] ?? '') === 'Recipe Submission' ? 'selected' : ''; ?>>Recipe Submission</option>
                                <option value="Website Feedback" <?php echo ($_POST['subject'] ?? '') === 'Website Feedback' ? 'selected' : ''; ?>>Website Feedback</option>
                                <option value="Technical Issue" <?php echo ($_POST['subject'] ?? '') === 'Technical Issue' ? 'selected' : ''; ?>>Technical Issue</option>
                                <option value="Other" <?php echo ($_POST['subject'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" rows="6" required 
                                      placeholder="Tell us about your question, suggestion, or recipe..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary">Send Message</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>