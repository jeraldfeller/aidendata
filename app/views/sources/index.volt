{% extends "_templates/basic.volt" %}
{% block body_attributes %} id="datatables"{%endblock %}
{% block body %}

    <div id="wrapper">
        {% include "_templates/navigation.volt" %}

        <div id="content">

            <div class="menubar">
                <div class="sidebar-toggler visible-xs">
                    <i class="ion-navicon"></i>
                </div>

                <div class="page-title">
                    Scraping Sources
                </div>
            </div>

            <div class="content-wrapper">

                {% include "_templates/flashMessages.volt" %}

                {% if scrapeSources|length > 0 %}

                    <div id="sources-datatable" class="dataTables_wrapper my-3" role="grid">

                        <table id="source-table" class="dataTable">
                            <thead>
                                <tr>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable">Name</th>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable">Scrape URL</th>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable">Regex pattern</th>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable">Scraping Depth</th>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable"># PDFs</th>
                                    <th scope="columnheader" class="sorting" aria-controls="sources-datatable">Last crawl</th>
                                    <th scope="columnheader">Options</th>
                                </tr>
                            </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                {% for scrapeSource in scrapeSources %}

                                    {% set initialLoopIndex = loop.index %}

                                    {% if scrapeSource.ScrapeUrls|length > 0 %}

                                        {% for scrapeUrl in scrapeSource.ScrapeUrls %}

                                            <tr class="{% if initialLoopIndex % 2 %}odd{%else%}even{%endif%}">

                                                {# Add Scrape Source once #}
                                                {% if loop.first %}
                                                    <td rowspan="{{ scrapeSource.ScrapeUrls|length }}" class="align-middle">
                                                        {{ scrapeSource.name }}
                                                    </td>
                                                {% endif %}

                                                <td>
                                                    <a href="{{ scrapeUrl.scrape_url }}" title="{{ scrapeUrl.scrape_url }}" target="_blank">
                                                        {{ scrapeUrl.getShorterUrl() }}
                                                    </a>
                                                </td>
                                                <td>{{ scrapeUrl.regex_pattern }}</td>
                                                <td class="text-center">{{ scrapeUrl.depth_level }}</td>

                                                {% if loop.first %}
                                                    <td rowspan="{{ scrapeSource.ScrapeUrls|length }}" class="align-middle text-center">
                                                        {% if scrapeSource.Pdfs|length is 0 %}
                                                            <span class="text-danger font-weight-bold">0</span>
                                                        {% else %}

                                                            {% if scrapeSource.hasAllPdfsAnalysed() %}
                                                                <span class="text-success">
                                                                    <strong>{{ scrapeSource.Pdfs|length }}</strong>
                                                                </span>
                                                            {% else %}
                                                                {{ scrapeSource.Pdfs|length }}
                                                            {% endif %}
                                                        {% endif %}
                                                    </td>
                                                {% endif %}

                                                <td class="text-center">
                                                    {% if scrapeUrl.last_crawl != null %}
                                                        <time class="timeago" datetime="{{ parseMySqlDateTime(scrapeUrl.last_crawl).format('c') }}">
                                                            {{ parseMySqlDateTime(scrapeUrl.last_crawl).format('H:i:s') }}
                                                        </time>
                                                    {% else %}

                                                    {% endif %}
                                                </td>

                                                <td>
                                                    {% include "_templates/sourcesOptions.volt" %}
                                                </td>

                                            </tr>

                                        {% endfor %}

                                    {% else %} {# No Scrape URLs #}

                                        <tr>

                                            <td>{{ scrapeSource.name }}</td>
                                            <td colspan="5" class="text-muted">
                                                There are no URLs added to this source.
                                            </td>

                                            <td>
                                                {% include "_templates/sourcesOptions.volt" %}
                                            </td>

                                        </tr>

                                    {% endif %}

                                {% endfor %}
                            </tbody>
                        </table>

                    </div>

                {% else %}

                    There are no scraping sources available.

                {% endif %}

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#source-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>
{% endblock %}

