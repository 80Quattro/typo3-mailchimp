(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('[data-msmailchimp-form]');

        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                const messageElement = form.parentElement.querySelector('[data-msmailchimp-message]');
                const submitButton = form.querySelector('button[type="submit"]');
                const emailInput = form.querySelector('input[name="email"]');

                if (!emailInput || !submitButton || !messageElement) {
                    return;
                }

                submitButton.disabled = true;
                messageElement.style.display = 'none';
                messageElement.className = 'msmailchimp-message';

                const formData = new FormData(form);
                const actionUrl = form.getAttribute('action');

                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        messageElement.textContent = data.message;
                        messageElement.classList.add(
                            data.success ? 'msmailchimp-message--success' : 'msmailchimp-message--error'
                        );
                        messageElement.style.display = 'block';

                        if (data.success) {
                            emailInput.value = '';
                        }
                    })
                    .catch(function () {
                        messageElement.textContent = 'An error occurred. Please try again.';
                        messageElement.classList.add('msmailchimp-message--error');
                        messageElement.style.display = 'block';
                    })
                    .finally(function () {
                        submitButton.disabled = false;
                    });
            });
        });
    });
})();