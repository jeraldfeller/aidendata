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
                    {{ pdf.getFileName() }} - {{ pdf.getStatusString() }}
                </div>
            </div>

            <div class="content-wrapper">
                
                <div class="text-center">
                    <a class="btn btn-primary" href="{{ pdf.url }}">Download / View PDF</a>
                </div>

                {% include "_templates/flashMessages.volt" %}

                <div class="row">

                    <div class="col-lg-12">

                        <a class="text-muted m-1" href="{{ url('pdfs') }}">&larr; Back to PDFs</a>

                        {% if pdf.Matches|length > 0 %}
                            <div id="matches-datatable" class="dataTables_wrapper my-3" role="grid">

                                <table id="match-table" class="dataTable">
                                    <thead>
                                        <tr>
                                            <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Phrase</th>
                                            <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Excerpt</th>
                                            <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Page</th>
                                        </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        {% for match in pdf.Matches %}
                                            <tr>
                                                <td>{{ match.Phrase.text }}</td>
                                                <td><em>{{ match.getHighlightedExcerptHtml() }}</em></td>
                                                <td>{{ match.page }}</td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>

                            </div>

                        {% else %}

                            <div class="text-center">
                                There were no matches found in this PDF.
                            </div>

                        {% endif %}

                    </div>

                </div>



            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#match-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>

{% endblock %}


