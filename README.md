# SilverStripe Easy ReCAPTCHA

## About

Allows for easy and quick implementation of the Google ReCAPTCHA v2.0

## Installation

```
composer require adair-creative/recaptcha
```

## Guide

config.yml
```
AdairCreative\ReCAPTCHA:
	secret_key: [your-secret-key]
	app_key: [your-public-app-key]
```

PageController.php
```
protected function init() {
	...
	ReCAPTCHA::importJavascript();
	ReCAPTCHA::importCSS();
	...
}
```

YourForm.php
```
public function __construct(ContentController $controller, string $name) {
	$fields = new FieldList([
		TextField::create("Message", "")
	]);

	ReCAPTCHA::addField($fields);

	return parent::__construct(
		$controller,
		$name,
		$fields,
		new FieldList([]),
		new FieldList([
		"Message"
		])
	);
}
```
