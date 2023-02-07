<?php

namespace Telemetry;

class XmlParser
{
    private $xml_parser;
    private $parsed_data;
    private $element_name;
    private $arr_temporary_attributes;
    private $xml_string_to_parse;

    public function __construct()
    {
        $this->parsed_data = [];
    }

    public function __destruct()
    {
        xml_parser_free($this->xml_parser);
    }

    public function setXmlStringToParse($xml_string_to_parse)
    {
        $this->xml_string_to_parse = $xml_string_to_parse;
    }

    public function getParsedData()
    {
        return $this->parsed_data;
    }

    public function parseTheXmlString()
    {
        $this->xml_parser = xml_parser_create();
        xml_set_object($this->xml_parser, $this);

        xml_set_element_handler($this->xml_parser, "open_element", close_element);
        xml_set_character_data_handler($this->xml_parser, "process_element_data");

        $this->parseTheDataString();
    }

    private function parseTheDataString()
    {
        $this->xml_parser($this->xml_parser, $this->xml_string_to_parse);
    }
}