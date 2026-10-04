# Holiday Providers

'Providers' is nothing but a fancy word in {{ siteName }} for a country or a subdivision: however these are the
components of the library that provide and calculate the holidays. {{ siteName }}'s focus is primarily only
official holidays and non-working days, however other type of holidays or events will be added when possible.

## Coverage

The latest release of {{ siteName }} supports {{ provider_stats['total'] }} providers ({{ provider_stats['regions'] }}
countries and {{ provider_stats['sub-regions'] }} subdivisions):

![World Map showing supported providers](../assets/img/map_providers.svg)

{% for id, provider in providers %}

- [{{ provider }}]({{ id | lower }}.md )

{% endfor %}

<style>
#world-map-providers {
  margin-top: 2em;

  svg {
    fill: #9AE6B4;
    fill-opacity: 1;
    stroke: white;
    stroke-opacity: 1;
    stroke-width: 0.5;
    stroke-linejoin: round;
    stroke-linecap: round;

    {{ id_list }} {
        fill: #028090;
    }
  }
</style>
