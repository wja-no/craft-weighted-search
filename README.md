# Weighted Search for the Craft CMS

This is a plugin for [Craft CMS](http://buildwithcraft.com/) which provides a
custom search function that can be used e.g. to build a search form.

- Search results are weighted based on number of hits in fields and title; hits
  in the title count more, exact matches of the title count even more
- Show an extract of the text that surrounds the search term
- Associate entries with search terms to editorially boost their relevance

## Installation

1. Copy or move the weightedsearch directory into `craft/plugins`
2. Find the plugin in Craft settings (`/admin/settings/plugins`) and click
   Install

## Usage

The `craft.weightedSearch.substringSearch` function takes a search string as a
parameter and returns an array of results that is sorted from most relevant to
least relevant.

Each result has these fields: `entry`, `excerpt` and `score`. The
excerpt is in HTML format, where each instance of the search string has been
marked up with the `mark` element.

You can leverage `entry` as you would any other [ElementCriteriaModel](https://craftcms.com/docs/templating/elementcriteriamodel) (eg. `{{searchresult.entry.title}}`).  

Example template code:

```
 {% set query = craft.request.getParam('q') %}
 {% set results = craft.weightedSearch.substringSearch(query) %}
 {% if results %}
     <ul>
         {% for searchResult in results %}
             <li>
                 <a href="{{ searchResult.entry.url }}">{{ searchResult.entry.title }}</a>
                 <img src="{{searchResult.entry.thumbnail.first().url" alt="{{searchResult.entry.thumbnailAltText}}">
                 <p>{{ searchResult.excerpt|raw }}</p>
                 <!-- Score: {{ searchResult.score }} -->
             </li>
         {% endfor %}
     </ul>
 {% else %}
     <p>{{ "No results"|t }}</p>
 {% endif %}
```

## Editorially prioritizing an entry for a search term

To enable manual prioritization of entries, create a field of type Tags, give
it the handle `prioritizedSearchTerms` and add it to the relevant entry types.

To give an entry prioritization in the search results for a given term, add
that term as a tag in the entry's `prioritizedSearchTerms` field. The entry
will receive a significant boost to its score, which will most likely be enough
to "win" over any other entry (that doesn't also have the same tag).

## Possible code adaptations

By editing the constants in the WeightedSearch_EntriesService class, it is
possible to adjust the length of the excerpt as well as the relative weights
assigned to search hits in entry titles and entries that have been editorially
prioritized.

Search hits in one type of entry can be "reassigned" to a different type by
adding code for it in the `getViewableEntry` function. (Example case: an entry
type that doesn't have its own URLs/template but whose contents are used by a
different entry type's template.)