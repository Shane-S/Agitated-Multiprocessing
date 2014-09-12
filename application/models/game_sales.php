<?php

class Game_Sales extends CI_Model
{
    var $root;
    var $sales_array;
    function __construct()
    {
        parent::__construct();
        $this->root = simplexml_load_file(XML_FOLDER . 'trends.xml');
        $this->sales_array = $this->_build_sales_array();
    }
    
    /*
     * Loops through the XML to build an associative array of all sales.
     * 
     * The elements are constructed using their relevant attributes, e.g. to acess
     * the console sales from 2007, one would write "all_sales['2007']['console']".
     * 
     * @return The associative array of sales as described above.
     */
    function _build_sales_array()
    {
        $all_sales = array();
        foreach($this->root->sales as $sales_elem)
        {
            $sales = array();
            foreach($sales_elem->platform as $platform)
            {
                $percentages = array();
                foreach($platform->sale as $sale)
                    $percentages[(string)$sale->genre] = $sale->percentage == 0 ? 'No data' : (string)$sale->percentage;

                $sales[(string)$platform['type']] = $percentages;
            }
            $all_sales[(string)$sales_elem['year']] = $sales;
        }
        return $all_sales;
    }
    
    /*
     * Returns the column headings.
     * 
     * Loops through one of the percentage array to retrieve all of the genres,
     * which are to be used as column headings.
     * 
     * @return Array containing the genres.
     */
    function get_headings()
    {
        $headings = array();
        foreach($this->root->sales->platform->sale as $sale)
            $headings[] = (string)$sale->genre;

        return $headings;
    }
    
    /*
     * Gets the years for which there's sales data.
     * 
     * @return An array of years with sales data.
     */
    function get_years()
    {
        $years = array();
        foreach(array_keys($this->sales_array) as $year)
            $years[] = $year;
        
        return $years;
    }
    
    /*
     * Returns the platform types for a given year.
     * 
     * @return An array containing the platform types for the specified year.
     */
    function get_platforms($year)
    {
        $platforms = array();
        foreach(array_keys($this->sales_array[$year]) as $platform)
            $platforms[] = $platform;
        
        return $platforms;
    }
    
    /*
     * Returns the sales for a given year and platform.
     * 
     * The array contains both the genre and its associated sales percentage.
     * This allows the controller to list the sales data in the order of the
     * headings, ensuring that the data end up in the correct columns.
     * 
     * @return An array of genres and their associated sales percentages.
     */
    function get_sales($year, $platform)
    {
        $sales = array();
        foreach($this->sales_array[$year][$platform] as $genre => $percentage)
            $sales[$genre] = $percentage;
        
        return $sales;
    }
}
