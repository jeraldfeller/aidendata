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
                        PDFs
                    </div>
                </div>

                <div class="content-wrapper">

                    {% include "_templates/flashMessages.volt" %}
                    {% if page.items|length > 0 %}

                        <div class="text-center">
                            {% include "_templates/pagination.volt" %}
                        </div>  

                        <div id="pdf-datatable" class="dataTables_wrapper" role="grid">

                            <table id="pdf-table" class="dataTable">
                                <thead>
                                    <tr role="row">
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Sources</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">URL</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Status</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Phrases Found</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Last checked</th>
                                        <th scope="columnheader">Options</th>
                                    </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    {% for pdf in page.items %}
                                        <tr class="{% if loop.index % 2 %}odd{%else%}even{%endif%}">
                                            <td>{{ pdf.ScrapeSource.name|e }}</td>
                                           
                                            <td>
                                                <a href="{{ url('pdfs/view?id=' ~ pdf.id) }}">
                                                    {{ pdf.getFileName() }}
                                                </a>
                                            </td>
                                            <td class="text-center">{{ pdf.getStatusString() }}</td>
                                            <td class="text-center">{{ pdf.Matches|length }}</td>

                                            <td>
                                                {% if pdf.last_checked is not null %}
                                                    <time class="timeago text-muted small" datetime="{{ parseMySqlDateTime(pdf.last_checked).format('c') }}">
                                                        {{ pdf.last_checked }}
                                                    </time>
                                                {% endif %}
                                            </td>

                                            <td>
                                                {% include "_templates/pdfsOptions.volt" %}
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </tbody>
                            </table>

                        </div>

                        <div class="text-center">
                            {% include "_templates/pagination.volt" %}
                        </div>  

                    {% else %}

                        <div class="text-center">
                            There are no PDFs available.
                        </div>

                    {% endif %}
                </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#pdf-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>
{% endblock %}


