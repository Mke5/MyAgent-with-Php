document.addEventListener('DOMContentLoaded', () => {
    // Contact Us button
    const contactBtn = document.getElementById('contact-us-btn');
    const contactCard = document.getElementById('contact-card');
    const closeContactCardBtn = document.getElementById('close-contact-card');

    // Email form card
    const emailLink = document.getElementById('email-link');
    const emailFormCard = document.getElementById('email-form-card');
    const closeEmailFormBtn = document.getElementById('close-email-form');
    const contactForm = document.getElementById('contact-form');
    const nameInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    // Open contact card
    contactBtn.addEventListener('click', () => {
        contactCard.style.display = 'flex'; // Show the contact card
    });

    // Close contact card
    closeContactCardBtn.addEventListener('click', () => {
        contactCard.style.display = 'none'; // Hide the contact card
    });

    // Open email form card when email is clicked
    emailLink.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent the default email link action
        contactCard.style.display = 'none'; // Hide the contact card
        emailFormCard.style.display = 'flex'; // Show the email form
    });

    // Close email form card
    closeEmailFormBtn.addEventListener('click', () => {
        emailFormCard.style.display = 'none'; // Hide the email form card
        contactCard.style.display = 'flex'; // Show the contact card again
    });

    // Handle form submission (here we just log the values; you can send via email or API)
    contactForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the form from submitting
        const name = nameInput.value;
        const message = messageInput.value;

        console.log(`Name: ${name}, Message: ${message}`);
        
        // You can send the form data to your email here via an API or backend
        // Example: sendEmail(name, message); (Implement this function as needed)

        // Reset the form
        nameInput.value = '';
        messageInput.value = '';

        // Close the form and show the contact card
        emailFormCard.style.display = 'none';
        contactCard.style.display = 'flex';
    });

    // When the WhatsApp number is clicked, open WhatsApp chat
    const whatsappLink = document.getElementById('whatsapp-link');
    whatsappLink.addEventListener('click', () => {
        window.open('https://wa.me/08021102824', '_blank'); // Replace with your WhatsApp number
    });

    // When the phone number is clicked, open phone app for calling
    const phoneLink = document.getElementById('phone-link');
    phoneLink.addEventListener('click', () => {
        window.location.href = 'tel:+2348021102824'; // Replace with your phone number
    });

    // Close the contact card if the user clicks outside of it
    window.addEventListener('click', (event) => {
        if (!contactCard.contains(event.target) && event.target !== contactBtn) {
            contactCard.style.display = 'none'; // Close the contact card if click is outside
        }
        
        if (!emailFormCard.contains(event.target) && event.target !== emailLink) {
            emailFormCard.style.display = 'none'; // Close the email form card if click is outside
        }
    });
});
