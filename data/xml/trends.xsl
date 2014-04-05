<?xml version="1.0" encoding="ISO-8859-1"?>
<!-- Edited by XMLSpy® -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--
  - Creates the genre headings to be displayed at the top of the table.
  -->
<xsl:template name="headings">
    <thead>
     <tr>
        <th></th>
        <xsl:for-each select="/game_sales/sales[1]/platform[1]/sale">
            <th><xsl:value-of select="genre"/></th>
        </xsl:for-each>
     </tr>
     </thead>
</xsl:template>

<!--
  - Reports the percent sales for each genre in a given year.
  -->
<xsl:template name="report_line">
    <xsl:for-each select="sale">
        <xsl:choose>
            <xsl:when test="percentage != '0.0'">
                <td><xsl:value-of select="percentage"/></td>
            </xsl:when>
            <xsl:otherwise>
                <td>No data</td>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:for-each>
</xsl:template>

<!--
  - Reports the sales for each platform in a given year, and displays the average
  - sales for each genre at the end.
  -->
<xsl:template name="annual_report">
    <xsl:variable name="year" select="@year"/>
    <tr>
    <td><xsl:value-of select="$year"/></td>
    </tr>
    <xsl:for-each select="platform">
        <tr>
            <td><xsl:value-of select="@type"/></td>
            <xsl:call-template name="report_line"/>
        </tr>
    </xsl:for-each>
    <tr>
    <td>Annual Averages</td>
    <!-- Selects all genres, then averages their sales for the given year -->
    <xsl:for-each select="/game_sales/sales[1]/platform[1]/sale">
        <xsl:variable name="cur_genre" select="genre"/>
        <xsl:variable name="year_genres" select="//sales[@year=$year]/platform/sale[genre=$cur_genre]"/>
        <xsl:variable name="average" select="sum($year_genres/percentage) div count($year_genres)"/>
        <td>
            <xsl:value-of select="format-number($average, '0.###')"/>
        </td>
    </xsl:for-each>
    </tr>
</xsl:template>

<!--
  - Displays the trends report, calling the necessary templates to fill in the
  - details for each year and to determine the world average.
  -->
<xsl:template match="/">
    <xsl:call-template name="headings"/>
    <xsl:for-each select="game_sales/sales">
        <xsl:call-template name="annual_report"/>
    </xsl:for-each>
    <tr>
        <td>CUMULATIVE AVERAGES</td>
        <!-- Loops through all genres, selecting every sales figure for each and averaging them -->
        <xsl:for-each select="/game_sales/sales[1]/platform[1]/sale">
            <xsl:variable name="cur_genre" select="genre"/>
            <xsl:variable name="all_genres" select="//platform/sale[genre=$cur_genre]"/>
            <xsl:variable name="average" select="sum($all_genres/percentage) div count($all_genres)"/>
            <td>
                <xsl:value-of select="format-number($average, '0.###')"/>
            </td>
        </xsl:for-each>
    </tr>
</xsl:template>

</xsl:stylesheet>
