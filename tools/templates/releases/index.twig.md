# Releases

Generally a new version of {{ siteName }} is released whenever there are a significant number of features and fixes, or when
there are critical (security) issues resolved. See below for information about each release.

{% for release in releases %}

## [{{ release.tag }}](./{{ release.tag }}.md)

_Released on {{ release.published_at | date('F j, Y') }}_

- GitHub: [`{{ release.tag }}`](https://github.com/azuyalabs/yasumi/releases/tag/{{ release.tag }})

{% endfor %}
