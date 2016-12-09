<?php
namespace Craft;

class WeightedSearchVariable
{
    /**
     * Search entries in the current locale for the given substring/"needle".
     *
     * Returns an array of search result items, where a search result item has
     * the following fields: 'url', 'title', 'excerpt' and 'score'.
     *
     * The excerpt is given in HTML format and may be an empty string. Else it
     * contains some text where the 'needle' appears in context. The instances
     * of the 'needle' are wrapped in <mark> elements. No other elements will
     * appear, so the excerpt can be put inside e.g. a <p> element without
     * triggering validity issues.
     *
     * Entries can be manually prioritized for particular searches by adding
     * search terms to a 'prioritizedSearchTerms' Tag field on the entry.
     *
     * Example usage in template:
     *
     * {% set query = craft.request.getParam('q') %}
     * {% set sections = ['articles', 'products'] %}
     * {% set results = craft.weightedSearch.substringSearch(query, sections) %}
     * {% if results %}
     *     <ul>
     *         {% for searchResult in results %}
     *             <li>
     *                 <a href="{{ searchResult.entry.url }}">{{ searchResult.entry.title }}</a>
     *                 <p>{{ searchResult.excerpt|raw }}</p>
     *                 <!-- Score: {{ searchResult.score }} -->
     *             </li>
     *         {% endfor %}
     *     </ul>
     * {% else %}
     *     <p>{{ "No results"|t }}</p>
     * {% endif %}
     *
     * The 'sections' argument (an array of handles to sections that are to be
     * searched) can be omitted; in this case, all sections will be searched.
     */
    public function substringSearch($needle, $sections = array())
    {
        $locale = craft()->language;
        return craft()->weightedSearch_entries->substringSearch($needle,
                $locale, $sections);
    }
}
