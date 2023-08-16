<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# Google reCAPTCHA widget

> **THIS IS A FORK FROM THE ARCHIVED [HIMIKLAB](https://github.com/himiklab/yii2-recaptcha-widget) REPOSITORY. THE MAIN GOAL IS TO SUPPORT LATEST PHP VERSIONS**

[![Tests](https://github.com/luyadev/yii2-recaptcha-widget/actions/workflows/tests.yml/badge.svg)](https://github.com/luyadev/yii2-recaptcha-widget/actions/workflows/tests.yml)
[![Total Downloads](https://poser.pugx.org/luyadev/yii2-recaptcha-widget/downloads)](https://packagist.org/packages/luyadev/yii2-recaptcha-widget)

## Installation

```sh
composer require luyadev/yii2-recaptcha-widget
```

Sign up [for an reCAPTCHA API keys](https://www.google.com/recaptcha/admin/create) and configure the component in your configuration file.

```php
'components' => [
    'reCaptcha' => [
        'class' => 'luyadev\recaptcha\ReCaptchaConfig',
        'siteKeyV2' => 'your siteKey v2',
        'secretV2' => 'your secret key v2',
        'siteKeyV3' => 'your siteKey v3',
        'secretV3' => 'your secret key v3',
    ],
    ...
``` 

Add `ReCaptchaValidator2` or `ReCaptchaValidator3` as validator into your model, do not forget to set those attributes as required.

```php
public $reCaptcha;

public function rules()
{
    return [
        [['reCaptcha'], 'required'],
        [['reCaptcha'], \luyadev\recaptcha\ReCaptchaValidator2::class, 'uncheckedMessage' => 'Please confirm that you are not a bot.'],
    ];
}
```

```php
public $reCaptcha;

public function rules()
{
    return [
        [['reCaptcha'], 'required'],
        [['reCaptcha'], \luyadev\recaptcha\ReCaptchaValidator3::class, 'threshold' => 0.5, 'action' => 'homepage'],
    ];
}
```

Usage in the view files for ActiveForm:

> NOTE: Disable ajax validation for ReCaptcha field!

```php
$form->field($model, 'reCaptcha')->widget(\luyadev\recaptcha\ReCaptcha2::class) // v2
```

```php
$form->field($model, 'reCaptcha')->widget(\luyadev\recaptcha\ReCaptcha3::class, ['action' => 'homepage']) // v3
```

as widgets:

```php
\luyadev\recaptcha\ReCaptcha2::widget([
    'name' => 'reCaptcha',
    'widgetOptions' => ['class' => 'col-sm-offset-3'],
]);
```

v3
```php
\luyadev\recaptcha\ReCaptcha3::widget([
    'name' => 'reCaptcha',
    'action' => 'homepage',
    'widgetOptions' => ['class' => 'col-sm-offset-3'],
]);
```