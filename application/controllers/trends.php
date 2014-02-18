<?php

class Trends extends Application {
    var $report;

    function __construct()
    {
        parent::__construct();
        $this->load->model('game_sales');
        $this->report = '';
    }
    
    function index()
    {
        $this->report .= $this->_build_report_headings();
        $this->report .= $this->_build_report_body();
        $this->load->helper('validation');

        $this->data['pagebody'] = "trendsView";
        $this->data['title'] = "Trends";
        $this->data['trends_xml'] = $this->report;
        $this->data['results'] = validate_dtd(XML_FOLDER . 'game_sales.xml');
        $this->render();
    }
    
    /*
     * Builds a report from the data provided by the trends model.
     * 
     * The function loops through the array returned from the model and runs it
     * through the template parser successively to obtain each piece of the final
     * report.
     * 
     * @return The HTML for the body of the report (i.e., the actual data).
     */
    function _build_report_body()
    {
        $years      = $this->game_sales->get_years();
        $headings   = $this->game_sales->get_headings();
        $report_body = '';
        $averages = array();
        
        // Zero out the annual averages arrays
        foreach($years as $year)
        {
            $averages[$year] = array();
            foreach($headings as $genre)
                $averages[$year][$genre] = 0;
        }
        
        foreach($years as $year)
        {
            // Assemble the opening
            $report_body .= $this->parser->parse('_opening', array('year' => $year), true);
            $annual_averages = array('annual_averages' => array());

            $platforms = $this->game_sales->get_platforms($year);
            $num_platforms = count($platforms);

            // Assemble the report lines using a helper function
            foreach($platforms as $platform)
                $report_body .= $this->_build_reportline($year, $platform, $headings, $averages[$year]);
            
            // Average the columns and assemble the closing
            foreach($headings as $genre)
            {
                $averages[$year][$genre] /= $num_platforms;
                $annual_averages['annual_averages'][$genre] = array('average' => $averages[$year][$genre]);
            }
            
            $report_body .= $this->parser->parse('_closing', $annual_averages, true);
        }
        
        // Calculate the totals and write their HTML to the report body
        $report_body .= $this->_build_cum_averages($averages, $headings, $years);
        return $report_body;
    }
    
    /*
     * Builds the report lines for a given year.
     * 
     * Loops through the array of percentages for the given platform, adding to 
     * the average as it goes. Parses the array once it's built, obtaining the 
     * HTML for the report line.
     * 
     * @param $year             The year when the sales in this report line o
     *                          ccurred.
     * @param $platform         The platform on which the games were sold.
     * @param $genres           The genres for which sales data are recorded.
     * @param $annual_averages  An array which will contain the average market
     *                          share for each genre from this year. This is
     *                          passed by reference.
     * 
     * @return The HTML for the given year and platform's report line.
     */
    function _build_reportline($year, $platform, $genres, &$annual_averages)
    {
        $report_line = '';
        $platform_sales = array('platform_type' => ucfirst($platform));
        $platform_sales['percentages'] = array();
        $sales = $this->game_sales->get_sales($year, $platform);

        // Loop through headings to list percentages array in the same order
        foreach($genres as $genre)
        {
            $avg_data = $sales[$genre] == 'No data' ? 0 : $sales[$genre]; // No data is assumed to be 0%
            $platform_sales['percentages'][] = array('percentage' => $sales[$genre]);
            $annual_averages[$genre] += (float)$avg_data;
        }

        $report_line .= $this->parser->parse('_reportline', $platform_sales, true);
        return $report_line;
    }
    
    /*
     * Calculates the cumulative averages for each of the genres and returns the
     * table HTML to contain them.
     * 
     * @param $averages The annual averages for each genre.
     * @param $genres   The list of genres for which we're calculating averages.
     * @param $years    The years when data for each genre was recorded.
     * 
     * @return The HTML string representing the averages in table columns.
     */
    function _build_cum_averages($averages, $genres, $years)
    {
        $num_years = count($years);
        $totals = array();
        $parsable_totals = array('cum_averages' => array());
        $cumulative_avgs = '';

        foreach($genres as $genre)
            $totals[$genre] = 0;

        foreach($years as $year)
        {
            foreach($genres as $genre)
                $totals[$genre] += $averages[$year][$genre];
        }
        
        foreach($genres as $genre)
        {
            $totals[$genre] = round($totals[$genre] /= $num_years, 3);
            $parsable_totals['cum_averages'][] = array('cum_average' => $totals[$genre]);
        }
        $cumulative_avgs .= $this->parser->parse('_totals', $parsable_totals, true);
        return $cumulative_avgs;
    }
    
    /*
     * Builds the table heading HTML for each genre.
     * 
     * @return An HTML string containing the genres in table columns.
     */
    function _build_report_headings()
    {
        $report_headings    = '';
        $parsable_headings  = array();
        $headings           = $this->game_sales->get_headings();

        foreach($headings as $genre)
            $parsable_headings['headings'][] = array('heading' => $genre);
        
        $report_headings .= $this->parser->parse('_headings', $parsable_headings, true);
        return $report_headings;
    }

}