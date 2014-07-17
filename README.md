# piwik

[Piwik](http://www.piwik.org)-Integration for ZendFramework2

This module integrates the piwik-tracking-code into all WebViews of your ZF2-Site

## Installation:

Piwik is best installed via [composer](http://getcomposer.org). Include the following line into the 
```require```-section of your ```composer.json```-File:

    "org_heigl/piwik" : "1.0.*"
    

## Usage:

 1. Add the module to the ```modules```-list of your applications ```application.config.php```-File.
 2. Copy this modules ```module.config.php```-File to your applications ```config/autoload``-directory and edit it according to your piwik-settings.
 3. There is no third step!
 
## Configuration:

The configuration consists of two parameters:

    return array(
        'orgHeiglPiwik' => array(
    
            // Always omit a trailing slash!
            'server' => 'example.org',
            'site_id' => 1,
        ), 
    );
    
 * **server** is the server your piwik installation is running at. Omit a trailing slash as well as a scheme (```http://``` or ```https://```). If you have installed piwik in a subdirectory you will have to include that here as well. So it would read ```example.org/piwik``` when you have installed your piwik-instance in the subdirectory ```piwik``` on the server ```example.org```.
 * **site_id** is the ID of the site you want to track as configured in your piwik-installation.

## Feedback:

Feel free to provide feedback by opening [issues](https://github.com/heiglandreas/piwik/issues) or pull-requests or by contacting me directly at ```piwik (AT) heigl (DOT) org```

## License:

This module is licensed according to the [LICENSE](LICENSE)-Document.

