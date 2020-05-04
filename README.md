# WP All Import Open Door Theme Add-On

Simple add-on for importing listings into the Open Door WordPress theme.

## taxonomies

### Features
`{property_type[1]}`

### Property Type
`{property_style[1]}`

### Price Ranges
`[get_price_range({numeric_price[1]})]`

### Location
{area[1]}

### Buy or Rent
`{department[1]}` with a mapping!
- Residential Lettings - Rent
- Residential Sales - Buy

## custom fields
### address
{house_number[1]} {street[1]}

### city and state
{town[1]}, {postcode[1]}, {postcode[1]}

### bedrooms
{bedrooms[1]}

### bathrooms
{bathrooms[1]}

### date available
{availableFrom[1]}

### school district
{district[1]}

### google maps location
{latitude[1]},{longitude[1]}

## Post content

```
<h2>Overview</h2>

<ul>
[output_bullet({bullet1[1]})]
[output_bullet({bullet2[1]})]
[output_bullet({bullet3[1]})]
[output_bullet({bullet4[1]})]
[output_bullet({bullet5[1]})]
[output_bullet({bullet6[1]})]
[output_bullet({bullet7[1]})]
</ul>

{main_advert[1]}

[FOREACH({rooms/room})]
[output_space_info({@name}, {./description[1]}, {./measurement_text[1]})]
[ENDFOREACH]

[FOREACH({rooms/room})]
[output_fees({@name}, {./description[1]}, {./measurement_text[1]})]
[ENDFOREACH]

[FOREACH({rooms/room})]
[output_directions({@name}, {./description[1]}, {./measurement_text[1]})]
[ENDFOREACH]

&nbsp;
<h2>More Information</h2>
<a href="{web_link[1]}">Click here to see more about the listing.</a>
&nbsp;
[output_floor_plan({floorplans[1]/floorplan[1]/filename[1]})]
&nbsp;
```

## Images

```
{pictures/picture/filename[1]}
```

## functions

```
<?php
function output_bullet($el) {
	if(!empty($el)) {
		return "<li>" . $el . "</li>";
	}
}
function output_directions($name, $desc, $measurement) {
	$out = '';
	if(!empty($desc) && $name == "Directions") {
		$out .= "<h2>" . $name . "</h2>";
		if(!empty($desc)) {
			$out .= $desc . "<br/>";
		}
	}
	return $out . "<br/>";
}

function output_fees($name, $desc, $measurement) {
	$out = '';
	if(!empty($desc) && $name == "Fees &amp; Charges") {
		$out .= "<h2>" . $name . "</h2>";
		if(!empty($desc)) {
			$out .= $desc . "<br/>";
		}
	}
	return $out . "<br/>";
}

function output_space_info($name, $desc, $measurement){
	$out = '';
	if($name != 'Directions') {
		$out .= "<b>" . $name . "</b><br/>";
		if(!empty($desc)) {
			$out .= "<b>Description:</b>&nbsp;" . $desc . "<br/>";
		}
		if(!empty($measurement)) {
			$out .= "<b>Measurements:</b>&nbsp;" . $measurement . "<br/>";
		}
	}
	return $out . "<br/>";
}
function output_floor_plan($element) {
	if(!empty($element)) {
		return "<h2>Floor Plan</h2><a href='". $element . "'>Click here to see the floor plan.</a>";
	}
}
/*
function output_html_with_title($element, $title) {
	if(!empty($element)) {
		return "<b>" . $title . "</b>&nbsp;" . $element;
	}
}*/
function get_price_range( $price = null ) {

    if ( !empty( $price ) ) {

        // Remove any extra characters from price.
        $price = preg_replace("/[^0-9,.]/", "", $price);

        if( $price < 1000 ) {
          return 'Under 1,000';
        } elseif( $price < 100000 ) {
          return '100,000 - 250,000';
        } elseif( $price < 250000 ) {
          return '100,000 - 250,000';
        } elseif( $price < 500000 ) {
          return '250,000 - 500,000';
        } else {
          return 'Over 500,000';
        }
    }
}

function round_price( $price = null, $multiplier = 1, $nearest = .01, $minus = 0 ) {

    if ( !empty( $price ) ) {

        // Remove any extra characters from price.
        $price = preg_replace("/[^0-9,.]/", "", $price);

        // Perform calculations and return rounded price.
        return ( round ( ( $price * $multiplier ) / $nearest ) * $nearest ) - $minus; 

    }
}
?>
```

## meta fields from theme with types

```
location_level1_value // drop-down - from theme options (wp_location_level1)

address_value // text, address for the listing
citystatezip_value // text: City and State/Province (or similar for your area) in one line

mls_value // text, required only if 'mlslisting_value' is Yes

mlslisting_value // drop-down: Yes or No

cr_value // drop-down: Residential or Commercial
agent_value // drop-down: another post type
agent2_value // drop-down: another post type
rob_value // drop-down: Rent or Buy

openhousedate_value // text, format: July 12, 2013
openhousetime_value // text, format: '1-4pm'

propertytype_value // drop-down - from theme options (wp_propertytype)! not from taxonomy
propertytype2_value // drop-down

beds_value // text, number of bedrooms
baths_value // text, number of bathrooms
size_value // text, The home/building size. Only number, no commas or text.
lotsize_value // text, lot size
garage_value // text, garage spaces

date_value // text, "format: July 12, 2013"
year_value //text, year built (e.g. 1980)
school_value // text, school district
google_location_value // text, can be 'lat,long'
streetview_value // drop-down: Yes or No
title_value // text, "Custom Slideshow Title"
email_value // text, Agent's email
phoneoffice_value // text, Agent's office number
phonemobile_value // text, Agent's mobile number
fax_value // text, Agent's mobile number

price_value // text, "How much is this property?"
pricecustom_value // text, Custom price text (Example: 'As low as $200,000')
reducedby_value // text, Price reduction (optional)

banner_value // "Type of banner" drop-down: Reduced,Sold,Pending,Reserved
banner2_value  // "Type of banner" drop-down: Reduced,Sold,Pending,Reserved
```

## meta fields from theme

```
location_level1_value
location_level2_value
address_value
citystatezip_value
mls_value
mlslisting_value
cr_value
agent_value
agent2_value
rob_value
openhousedate_value
openhousetime_value
propertytype_value
propertytype2_value
beds_value
baths_value
size_value
lotsize_value
garage_value
rob_value
date_value
rooms_value
basement_value
attic_value
deckpatio_value
year_value
school_value
google_location_value
streetview_value
title_value
email_value
phoneoffice_value
phonemobile_value
fax_value
contactformshortcode_value
agentorder_value
```
