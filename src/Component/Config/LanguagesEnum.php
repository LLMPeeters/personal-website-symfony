<?php

namespace App\Component\Config;

enum LanguagesEnum: string
{
	case ab = 'Abkhazian';
	case aa = 'Afar';
	case af = 'Afrikaans';
	case ak = 'Akan';
	case sq = 'Albanian';
	case am = 'Amharic';
	case ar = 'Arabic';
	case an = 'Aragonese';
	case hy = 'Armenian';
	case as = 'Assamese';
	case av = 'Avaric';
	case ae = 'Avestan';
	case ay = 'Aymara';
	case az = 'Azerbaijani';
	case bm = 'Bambara';
	case ba = 'Bashkir';
	case eu = 'Basque';
	case be = 'Belarusian';
	case bn = 'Bengali';
	case bh = 'Bihari languages';
	case bi = 'Bislama';
	case bs = 'Bosnian';
	case br = 'Breton';
	case bg = 'Bulgarian';
	case my = 'Burmese';
	case ca = 'Catalan, Valencian';
	case km = 'Central Khmer';
	case ch = 'Chamorro';
	case ce = 'Chechen';
	case ny = 'Chichewa, Chewa, Nyanja';
	case zh = 'Chinese';
	case cu = 'Church Slavonic, Old Bulgarian, Old Church Slavonic';
	case cv = 'Chuvash';
	case kw = 'Cornish';
	case co = 'Corsican';
	case cr = 'Cree';
	case hr = 'Croatian';
	case cs = 'Czech';
	case da = 'Danish';
	case dv = 'Divehi, Dhivehi, Maldivian';
	case nl = 'Dutch, Flemish';
	case dz = 'Dzongkha';
	case en = 'English';
	case eo = 'Esperanto';
	case et = 'Estonian';
	case ee = 'Ewe';
	case fo = 'Faroese';
	case fj = 'Fijian';
	case fi = 'Finnish';
	case fr = 'French';
	case ff = 'Fulah';
	case gd = 'Gaelic, Scottish Gaelic';
	case gl = 'Galician';
	case lg = 'Ganda';
	case ka = 'Georgian';
	case de = 'German';
	case ki = 'Gikuyu, Kikuyu';
	case el = 'Greek (Modern)';
	case kl = 'Greenlandic, Kalaallisut';
	case gn = 'Guarani';
	case gu = 'Gujarati';
	case ht = 'Haitian, Haitian Creole';
	case ha = 'Hausa';
	case he = 'Hebrew';
	case hz = 'Herero';
	case hi = 'Hindi';
	case ho = 'Hiri Motu';
	case hu = 'Hungarian';
	case is = 'Icelandic';
	case io = 'Ido';
	case ig = 'Igbo';
	case id = 'Indonesian';
	case ia = 'Interlingua (International Auxiliary Language Association)';
	case ie = 'Interlingue';
	case iu = 'Inuktitut';
	case ik = 'Inupiaq';
	case ga = 'Irish';
	case it = 'Italian';
	case ja = 'Japanese';
	case jv = 'Javanese';
	case kn = 'Kannada';
	case kr = 'Kanuri';
	case ks = 'Kashmiri';
	case kk = 'Kazakh';
	case rw = 'Kinyarwanda';
	case kv = 'Komi';
	case kg = 'Kongo';
	case ko = 'Korean';
	case kj = 'Kwanyama, Kuanyama';
	case ku = 'Kurdish';
	case ky = 'Kyrgyz';
	case lo = 'Lao';
	case la = 'Latin';
	case lv = 'Latvian';
	case lb = 'Letzeburgesch, Luxembourgish';
	case li = 'Limburgish, Limburgan, Limburger';
	case ln = 'Lingala';
	case lt = 'Lithuanian';
	case lu = 'Luba-Katanga';
	case mk = 'Macedonian';
	case mg = 'Malagasy';
	case ms = 'Malay';
	case ml = 'Malayalam';
	case mt = 'Maltese';
	case gv = 'Manx';
	case mi = 'Maori';
	case mr = 'Marathi';
	case mh = 'Marshallese';
	case ro = 'Moldovan, Moldavian, Romanian';
	case mn = 'Mongolian';
	case na = 'Nauru';
	case nv = 'Navajo, Navaho';
	case nd = 'Northern Ndebele';
	case ng = 'Ndonga';
	case ne = 'Nepali';
	case se = 'Northern Sami';
	case no = 'Norwegian';
	case nb = 'Norwegian Bokmål';
	case nn = 'Norwegian Nynorsk';
	case ii = 'Nuosu, Sichuan Yi';
	case oc = 'Occitan (post 1500)';
	case oj = 'Ojibwa';
	case or = 'Oriya';
	case om = 'Oromo';
	case os = 'Ossetian, Ossetic';
	case pi = 'Pali';
	case pa = 'Panjabi, Punjabi';
	case ps = 'Pashto, Pushto';
	case fa = 'Persian';
	case pl = 'Polish';
	case pt = 'Portuguese';
	case qu = 'Quechua';
	case rm = 'Romansh';
	case rn = 'Rundi';
	case ru = 'Russian';
	case sm = 'Samoan';
	case sg = 'Sango';
	case sa = 'Sanskrit';
	case sc = 'Sardinian';
	case sr = 'Serbian';
	case sn = 'Shona';
	case sd = 'Sindhi';
	case si = 'Sinhala, Sinhalese';
	case sk = 'Slovak';
	case sl = 'Slovenian';
	case so = 'Somali';
	case st = 'Sotho, Southern';
	case nr = 'South Ndebele';
	case es = 'Spanish, Castilian';
	case su = 'Sundanese';
	case sw = 'Swahili';
	case ss = 'Swati';
	case sv = 'Swedish';
	case tl = 'Tagalog';
	case ty = 'Tahitian';
	case tg = 'Tajik';
	case ta = 'Tamil';
	case tt = 'Tatar';
	case te = 'Telugu';
	case th = 'Thai';
	case bo = 'Tibetan';
	case ti = 'Tigrinya';
	case to = 'Tonga (Tonga Islands)';
	case ts = 'Tsonga';
	case tn = 'Tswana';
	case tr = 'Turkish';
	case tk = 'Turkmen';
	case tw = 'Twi';
	case ug = 'Uighur, Uyghur';
	case uk = 'Ukrainian';
	case ur = 'Urdu';
	case uz = 'Uzbek';
	case ve = 'Venda';
	case vi = 'Vietnamese';
	case vo = 'Volap_k';
	case wa = 'Walloon';
	case cy = 'Welsh';
	case fy = 'Western Frisian';
	case wo = 'Wolof';
	case xh = 'Xhosa';
	case yi = 'Yiddish';
	case yo = 'Yoruba';
	case za = 'Zhuang, Chuang';
	case zu = 'Zulu';
	
	public static function fromName(string $name): LanguagesEnum
	{
		foreach(self::cases() as $language) {
			if($name === $language->name) {
				return $language;
			}
		}
	}
	
	public static function tryFromName(string $name): ?LanguagesEnum
	{
		try {
			return self::fromName($name);
		} catch (\Exception $e) {
			return null;
		}
	}
}