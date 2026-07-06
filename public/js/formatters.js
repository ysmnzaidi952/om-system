/**
 * Malaysian IC Number & Phone Number Auto-Formatters
 * iBuruj-HSIS System
 */

// ============================================
// IC NUMBER FORMATTER
// ============================================
function formatICNumber(input) {
    // Remove all non-numeric characters
    let value = input.value.replace(/\D/g, '');
    
    // Limit to 12 digits
    if (value.length > 12) {
        value = value.substring(0, 12);
    }
    
    // Format with dashes: YYMMDD-PP-####
    let formatted = '';
    if (value.length > 0) {
        formatted = value.substring(0, 6); // YYMMDD
        if (value.length >= 7) {
            formatted += '-' + value.substring(6, 8); // PP
        }
        if (value.length >= 9) {
            formatted += '-' + value.substring(8, 12); // ####
        }
    }
    
    // Update display value
    input.value = formatted;
}

function setupICFormatter(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    // Format on input
    input.addEventListener('input', function(e) {
        formatICNumber(this);
    });
    
    // Format on paste
    input.addEventListener('paste', function(e) {
        setTimeout(() => formatICNumber(this), 0);
    });
    
    // Remove dashes before form submission to store clean digits
    const form = input.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const cleanIC = input.value.replace(/\D/g, '');
            
            let hiddenInput = form.querySelector('input[name="ic_clean"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ic_clean';
                form.appendChild(hiddenInput);
            }
            hiddenInput.value = cleanIC;
            
            input.name = 'ic_display';
            hiddenInput.name = 'ic';
        });
    }
    
    // Format existing value on page load
    if (input.value) {
        formatICNumber(input);
    }
}

// ============================================
// PHONE NUMBER FORMATTER
// ============================================
function formatPhoneNumber(input, hiddenInput) {
    // Get raw input
    let value = input.value.replace(/\D/g, ''); // Remove all non-digits
    
    // Handle different input formats
    if (value.startsWith('60')) {
        // Already has country code (60167890123)
        value = value.substring(2); // Remove 60, process as local
    } else if (value.startsWith('0')) {
        // Local format (0167890123)
        value = value.substring(1); // Remove leading 0
    }
    
    // Limit length
    // Standard mobile: 9-10 digits (after removing 0)
    // 011 numbers: 8-9 digits (after removing 0)
    if (value.length > 10) {
        value = value.substring(0, 10);
    }
    
    // Format for display: +60 XX-XXX XXXX or +60 XX-XXXX XXXX
    let formatted = '';
    let dbValue = '';
    
    if (value.length > 0) {
        // Check if it's 011 format (starts with 11 after 0)
        const firstTwoDigits = value.substring(0, 2);
        const is011Number = firstTwoDigits === '11';
        
        if (is011Number) {
            // Format: +60 11-XXXX XXXX (011 numbers are 8 digits after 11)
            formatted = '+60 11';
            if (value.length > 2) {
                formatted += '-' + value.substring(2, 6); // Next 4 digits
            }
            if (value.length > 6) {
                formatted += ' ' + value.substring(6, 10); // Last 4 digits
            }
        } else {
            // Format: +60 XX-XXX XXXX (normal mobile)
            formatted = '+60 ' + value.substring(0, 2); // First 2 digits (e.g., 16, 12, 13)
            if (value.length > 2) {
                formatted += '-' + value.substring(2, 5); // Next 3 digits
            }
            if (value.length > 5) {
                formatted += ' ' + value.substring(5, 9); // Last 4 digits
            }
        }
        
        // Database value: 60 + cleaned number
        dbValue = '60' + value;
    }
    
    // Update display input
    input.value = formatted;
    
    // Update hidden input for database
    if (hiddenInput) {
        hiddenInput.value = dbValue;
    }
}

function setupPhoneFormatter(inputId, hiddenInputId) {
    const input = document.getElementById(inputId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (!input) return;
    
    // Format on input
    input.addEventListener('input', function(e) {
        formatPhoneNumber(this, hiddenInput);
    });
    
    // Format on paste
    input.addEventListener('paste', function(e) {
        setTimeout(() => formatPhoneNumber(this, hiddenInput), 0);
    });
    
    // Format existing value on page load
    if (input.value) {
        formatPhoneNumber(input, hiddenInput);
    }
}

// ============================================
// AUTO-INITIALIZE ON PAGE LOAD
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize IC formatters
    const icInputs = document.querySelectorAll('input[name="ic"], #ic, input[data-format="ic"]');
    icInputs.forEach(input => {
        if (input.id) {
            setupICFormatter(input.id);
        }
    });
    
    // Initialize Phone formatters
    const phoneInputs = document.querySelectorAll('input[data-format="phone"]');
    phoneInputs.forEach(input => {
        const hiddenInputId = input.getAttribute('data-hidden-input');
        if (hiddenInputId) {
            setupPhoneFormatter(input.id, hiddenInputId);
        }
    });
});