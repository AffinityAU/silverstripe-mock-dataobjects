<?php

if(!class_exists("Faker\Generator")) {
    throw new RuntimeException("The silverstripe-mock-dataobjects module requires the Faker PHP library. You can install it by running 'composer require fzaninotto/faker:1.1.*@dev' in your web root. If you installed this module via composer, make the directory fzaninotto/faker exists in vendor/.");
}

define('MOCK_DATAOBJECTS_DIR',basename(dirname(__FILE__)));

Object::add_extension('DBField', 'MockDBField');

foreach(SS_ClassLoader::instance()->getManifest()->getDescendantsOf("DBField") as $class) {

    // Ensure that if the framework is 3.6.0 +, Float and Int fields are mapped appropriately to their mock<<db>>field classes.
    if($class == "DBFloat")
        $mockClass = 'MockFloatField';
    else if($class == "DBInt")
        $mockClass = 'MockIntField';
    else
        $mockClass = "Mock{$class}Field";

	if(class_exists($mockClass)) {
		Object::add_extension($class, $mockClass);
	}
}

CMSMenu::remove_menu_item('MockChildrenController');
