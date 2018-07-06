<?php

namespace App\Tests;

use App\Service\ChefkochDOMParser;
use PHPUnit\Framework\TestCase;

class ChefkochDOMParserTest extends TestCase {

	function testUrls() {
		$parser = new ChefkochDOMParser();
		self::assertTrue($parser->isApplicableForUrl('https://www.chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('http://www.chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('https://chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('http://chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('www.chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('//www.chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));
		self::assertTrue($parser->isApplicableForUrl('//chefkoch.de/rezepte/2708511423773201/Brioche-Burger-Bun.html'));

		self::assertFalse($parser->isApplicableForUrl('https://www.chefkoch.de/rs/s0g66/Backrezepte.html'));
		self::assertFalse($parser->isApplicableForUrl('https://www.ichkoche.at/nudeln-mit-baerlauch-und-thunfisch-rezept-223070'));
	}

	function testNudels() {
		// use internal errors so libxml won't throw php warnings/errors on non-wellformed docs
		libxml_use_internal_errors(true);

		$parser = new ChefkochDOMParser();
		$result = $parser->analyzeUrl('https://www.chefkoch.de/rezepte/1112191217260468/Nudelteig.html');

		self::assertContains('https://static.chefkoch-cdn.de/ck.de/rezepte/111/111219/268178-960x720-nudelteig.jpg', $result['images']);
		self::assertContains('https://static.chefkoch-cdn.de/ck.de/rezepte/111/111219/279051-960x720-nudelteig.jpg', $result['images']);
		self::assertContains('https://static.chefkoch-cdn.de/ck.de/rezepte/111/111219/238889-960x720-nudelteig.jpg', $result['images']);

		$ingredients = [
			["amount" => "4", "label" => "Eigelb"],
			["amount" => "1", "label" => "Ei(er)"],
			["amount" => "2 EL", "label" => "Olivenöl"],
			["amount" => "", "label" => "Salz"],
			["amount" => "400 g", "label" => "Mehl, ca."]
		];

		self::assertEquals('Nudelteig', $result['title']);
		self::assertEquals($ingredients, $result['ingredients']);

		self::assertContains('Für einen Nudelteig rechnet man pro Person ein Eigelb', $result['description']);
		self::assertContains('Den Teig zur Weiterarbeitung nun auf eine bemehlte Arbeitsfläche geben und den Teigball ', $result['description']);
		libxml_clear_errors();
	}

}
