# fprview - Fast product view

![fprview-frontend](#)

## Description
Fast product view plugin for Shop-Script

## Features
The plugin gives customers the ability to quickly view information about a product from a catalog pages. After clicking on the "Fast Preview" link a modal window opens with information about the product.

## Installing
### Auto
...

### Manual
1. Get the code into your web server's folder /PATH_TO_WEBASYST/wa-apps/shop/plugins

2. Add the following line into the /PATH_TO_WEBASYST/wa-config/apps/shop/plugins.php file (this file lists all installed shop plugins):

		'fprview' => true,

3. Done. Configure the plugin in the plugins tab of shop backend.

## Specificity
To output the "Fast Preview" link in shop frontend paste in the product template the following code:  
**{shopFprviewPlugin::displayButton($product.id)}** - as a method parameter it is necessary to specify the product id.

### The showing of the "Fast Preview" link in the categories, lists:
You need to edit the template that generates the product lists. In the basic themes of Shop-Script is used for this **list-thumbs.html** template. Add the next code inside the **foreach**:

		{shopFprviewPlugin::displayButton($p.id)}

![fprview-list-thumbs](#)

*The pictures show the principle and the approximate location of the calling plugin can be added to template files of basic design theme Custom. In other themes the plugin is installed the same way.*
