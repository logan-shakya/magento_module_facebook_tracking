# magento_module_facebook_tracking
FacebookTracking is a lightweight, custom-built Magento 2 module that integrates both Facebook Pixel (browser-side) and Facebook Conversions API (CAPI) (server-side). It provides accurate event tracking and enhanced Meta Ads attribution while keeping the code clean, modular, and dependency-free.

* * * * *

Facebook Tracking for Magento 2
===============================

A lightweight, custom Magento 2 extension that integrates **Facebook Pixel** and **Facebook Conversions API (CAPI)**.\
This extension enables accurate, reliable tracking for Meta Ads without relying on heavy third-party modules.

* * * * *

🚀 Features
-----------

### **Facebook Pixel (Browser-Side Tracking)**

-   Injects the Facebook Pixel script into the storefront `<head>`

-   Tracks events like **PageView**

-   Fully configurable from the Magento Admin

### **Facebook Conversions API (Server-Side Tracking)**

-   Sends **Purchase events** directly to Meta's Graph API

-   Triggered by Magento observers after a successful order

-   Sends:

    -   Hashed Email (SHA-256)

    -   Client IP

    -   User Agent

    -   Order ID

    -   Order Total

    -   Currency

-   Automatically disables CAPI calls if the access token is missing

* * * * *

⚙️ Admin Configuration
----------------------

You can configure the module from:

```
Stores → Configuration → Tracking → Facebook Tracking

```

Available fields:

-   **Enable Tracking**

-   **Facebook Pixel ID**

-   **Conversions API Access Token** (protected input)

* * * * *

🧱 Architecture Highlights
--------------------------

-   Namespace: `Tracking\FacebookTracking`

-   Uses Magento **Dependency Injection**, **Observers**, and **layout XML**

-   No rewrites, no core overrides --- upgrade-safe

-   Clean, simple folder structure

-   Custom API client built on **GuzzleHTTP**

-   Pixel script rendered via `.phtml` template for full flexibility

* * * * *

🧪 Debugging & Logs
-------------------

All Conversions API activity is logged to:

```
var/log/system.log

```

Logged data includes:

-   Request payloads sent to Facebook

-   Responses from the Graph API

-   Useful for testing even **without** Meta Events Manager

* * * * *
