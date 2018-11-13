# Custom Tabs & Fields for Woocommerce
Custom Tabs & Fields for Woocommerce is a Wordpress plugin to add custom tabs and custom meta-data to Woocommerce products.

![Alt text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/banner-772x250.jpg)
## Features

- Create/Disable/Delete custom tabs for Woocommerce products
- Create/Disable/Delete custom rich-text fields for Woocommerce products (simple/variable/grouped)
- Assign tabs to specific categories
- Add custom fields to specific custom tabs
- Add custom fields to the meta section of the single product page
- Order your custom fields with a simple drag&drop
- Empty fields not saved to database
- Easy import custom fields from external source using Woocommerce import features (see below for more explanation)
- Optimize DB option for better performance

## Documentation
Check our online ![documentation](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/wiki) 

## How it works?

With Custom Tabs & Fields for Woocommerce you can improve information about your shop products.
You can add unlimited custom tabs and assign them to specific product categories.
You can add unlimited custom fields and assign them to specific custom tabs.
Once you have defined your custom fields, they will be available in the product edit page, where you can input your data.
You can input data using the integrated wysiwyg editor so you can insert media files and so on.

Only fields with a value will be saved to database. 

After adding your Custom Tabs and editing your Custom Fields for the product they will be displayed in the product single page of your shop. 

Add custom fields to the single page meta section, setting the flag Product Page Meta to checked. 
Define your custom fields order dragging the custom fields rows to meet your needs.

### Main Screen
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-1.png)

### Custom Tabs list screen (admin)
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-2.png)
### Custom Tab edit screen (admin)
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-3.png)
### Custom Fields list screen (admin)
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-4.png)
### Product edit screen -> custom fields metabox (admin)
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-5.png)

### Product single page (demo)
![Alt_text](https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/blob/master/assets/screenshot-6.png)

## Import and Optimize DB

You can import your custom fields using the Woocommerce Import feature. 
Your CSV File only needs a column name heading for each custom field in the following format: <code>Meta: \mg_cf\_[custom_field_slug]</code> In the columns mapping select Import as meta

After importing data you should run the Optimize DB feature in order to clean all records with empty data.

## Premium Version?
Custom Tags And Fields for Woocommerce is completely free. 

## Support
For any issue please submit here:
If you have any issue please open an issue here https://github.com/swina/mg-custom-tabs-and-fields-for-woocommerce/issues

## Releases
0.2 - Fixed custom tabs display in the product page