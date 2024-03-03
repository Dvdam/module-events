# Module Events for Magento 2

## How to install & upgrade Dvdam_Events

### 1. Install via composer (recommend)

We recommend you to install Dvdam_Events module via composer. It is easy to install, update and maintaince.

Run the following command in Magento 2 root folder.

#### 1.1 Install

```
composer require dvdam/module-events
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```
Run compile if your store in Product mode:

```
php bin/magento setup:di:compile
```

### 2. Copy and paste

If you don't want to install via composer, you can use this way.

- Download
- Extract `module-events.zip` file to `app/code/Dvdam/Events` ; You should create a folder path `app/code/Dvdam/Events` if not exist.
- Go to Magento root folder and run upgrade command line to install `Dvdam_Events`:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 3. How to use
In Frontend area, to start working with Magento 2 Full Calendar, you need go to: 
- For example, `https://{YOUR-SITE}/full-calendar`

In Admin area, firstly login as Admin account and:
- Go to the path `DVDAM > Events`.


## 4. Working in progress
Feel free to **Fork** and contribute to this module. 

If you have any ideas, please create a pull request, then we will consider and merge your proposed changes in the main branch. 
