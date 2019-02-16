<div class="dropdown">
    <button 
        class="btn btn-default dropdown-toggle"
        type="button" 
        id="dropdownMenu-{{ scrapeSource.id }}" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        {% if scrapeSource.ScrapeUrls|length > 0 %}
            <li>
                <a href="{{ url('urls/delete?id=' ~ scrapeUrl.id) }}">Delete URL</a>
            </li>
        {% endif %}
        <li>
            <a href="{{ url('sources/delete?id=' ~ scrapeSource.id) }}">Delete Source</a>
        </li>
    </ul>
</div>
