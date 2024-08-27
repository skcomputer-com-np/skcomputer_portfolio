// This function is called when the reCAPTCHA library has loaded
var onloadCallback = function () {
  grecaptcha.render("html_element", {
    sitekey: "6LcbRi4qAAAAAB8TZyfT8Rfj1-RbjxmmGeNLbxJ4", // Replace with your site key
    callback: onCaptchaVerified, // Set the callback function
  });
};

// Function to enable submit button when CAPTCHA is successfully completed
function onCaptchaVerified() {
  document.getElementById("submitBtn").disabled = false;
}
