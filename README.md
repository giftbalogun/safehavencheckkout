
# SafeHaven WHMCS Plugin

Welcome to the SafeHaven WHMCS plugin repository on GitHub. 

Here you can browse the source code, look at open issues and keep track of development.

## Installation 

### Requirements

- Existing WHMCS installation on your web server.
- Supported Web Servers: Apache and Nginx
- PHP (5.5.19 or more recent) and extensions, MySQL and web browser
- cURL (7.34.0 or more recent)
- OpenSSL v1.0.1 or more recent

### Prepare

- Before you can start taking payments through SafeHaven, you will first need to sign up at: 
[https://safehavenmfb.com][link-signup]. To receive live payments, you should request a Go-live after
you are done with configuration and have successfully made a test payment.

### Install
1. Copy [safehavencheckout.php](modules/gateways/safehavencheckout.php?raw=true) in [modules/gateways](modules/gateways) to the `/modules/gateways/` folder of your WHMCS installation.

2. Copy [safehavencheckout.php](modules/gateways/callback/safehavencheckout.php?raw=true) in [modules/gateways/callback](modules/gateways/callback) to the `/modules/gateways/callback` folder of your WHMCS installation.

## Documentation

* [SafeHaven Documentation](https://safehavenmfb.readme.io/reference)
* [SafeHaven Helpdesk](https://safehavenmfb.com/help)

## Support

For bug reports and feature requests directly related to this plugin, please use the [issue tracker](https://github.com/giftbalogun/safehavencheckkout/issues). 

For general support or questions about your SafeHaven account, you can reach out by sending a message from [our website](https://safehavenmfb.com/contact).
