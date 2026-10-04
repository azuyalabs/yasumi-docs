# {{ provider['name'] }}{% if provider['parent'] %} ({{ provider['parent'] }}){% endif ~%}

There are _{{ provider['count'] }}_ registered holidays for the **{{ provider['name'] }}** provider in **2026**.

{% if provider['incomplete'] %}
!!! warning "Incomplete implementation"

    Not all holidays are implemented for the **{{ provider['name'] }}** provider.
    {{ provider['incomplete'] }}

{% endif %}
!!! info ""

    The below listed holidays (and the aforementioned number of holidays) merely reflect which holidays are registered
    with the {{ provider['name'] }} provider in {{ siteName }}. These do not indicate whether a particular holiday is
    considered a non-working day or not.

    Although {{ siteName }} has the ability to classify holidays (e.g. 'Official', 'Regional', etc.), this isn't optimal
    feature and consider changing this in a future release.

## Holidays

|     | Date | Day of the week | Name | Type |
| --- | ---- | --------------- | ---- | ---- |
{% for holiday in provider['holidays'] %}
{% if holiday.is_observed %}
{% set holidayType = ':fontawesome-solid-repeat:' %}
{% set holidayTypeTitle = 'Substituted holiday' %}
{% else %}
{% set holidayType = ':fontawesome-solid-leaf:' %}
{% set holidayTypeTitle = 'Regular holiday' %}
{% endif %}
| {{ holidayType }}{ .icon title="{{ holidayTypeTitle }}" } | {{ holiday.date }} | {{ holiday.day_of_week }} | {{ holiday.name }} | {{ holiday.type | capitalize }} |
{% endfor %}

??? info "Legend"

    - **Official** - Holidays that are marked as public or statutory.
    - **Observance** - Holidays that are not necessarily official however are being observed.
    - **Bank** - A public holiday in the United Kingdom, some Commonwealth countries and some other European countries.
    - **Seasonal** - Holidays that are celebrated due to its seasonal character (e.g. Halloween).
    - **Other** - Holidays that fall outside any of the above type.

## Sources

The following list of sources are used for determining the calculation logic of
the holidays given by the **{{ provider['name'] }}** Holiday provider.

{% for source in provider['sources'] %}

1. [{{ source }}]({{ source | raw }})
   {% endfor %}
