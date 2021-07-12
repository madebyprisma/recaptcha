Array.from(document.querySelectorAll("form")).forEach((form, index) => {
	let input = form.querySelector(`input[name="CaptchaToken"]`);

	if (input) {
		let captcha = document.createElement("div");
		captcha.className = "g-recaptcha";
		captcha.dataset.callback = "captchaCallback_" + index;
		captcha.dataset.sitekey = input.dataset.key;

		input.after(captcha);

		globalThis[`captchaCallback_${index}`] = token => input.value = token;
	}
});

let script = document.createElement("script");
script.src = "https://www.google.com/recaptcha/api.js";
document.body.appendChild(script);
