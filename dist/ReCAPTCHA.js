globalThis.captchaCallback = () => undefined;

let form = Array.from(document.querySelectorAll("form")).filter(form => !!form.querySelector(`input[name="CaptchaToken"]`))[0];

if (form) {
	let input = form.querySelector(`input[name="CaptchaToken"]`);

	let captcha = document.createElement("div");
	captcha.className = "g-recaptcha";
	captcha.dataset.callback = "captchaCallback";
	captcha.dataset.sitekey = input.dataset.sitekey;

	input.after(captcha);

	globalThis.captchaCallback = token => input.value = token;

	let script = document.createElement("script");
	script.src = "https://www.google.com/recaptcha/api.js";
	document.body.appendChild(script);
}
