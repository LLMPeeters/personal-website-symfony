<?php

namespace App\Component\Pages;

enum ComplexPageItemsEnum: string
{
	case HEADING_ONE = 'H1';
	case HEADING_TWO = 'H2';
	case HEADING_THREE = 'H3';
	case HEADING_FOUR = 'H4';
	case HEADING_FIVE = 'H5';
	case HEADING_SIX = 'H6';
	
	case PARAGRAPH = 'P';
	
	case WIDGET = 'WIDGET';
}