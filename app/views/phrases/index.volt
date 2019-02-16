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
                    Phrases
                </div>
            </div>

            <div class="content-wrapper">

                {% include "_templates/flashMessages.volt" %}

                {% if phrases|length > 0 %}

                    <div id="phrases-datatable" class="dataTables_wrapper my-3" role="grid">

                        <table id="phrase-table" class="dataTable">
                            <thead>
                                <tr>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Phrase</th>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Case Sensitive</th>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Occurences</th>
                                    <th scope="columnheader">Options</th>
                                </tr>
                            </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                {% for phrase in phrases %}
                                    <tr class="{% if loop.index % 2 %}odd{%else%}even{%endif%}">
                                        <td>{{ phrase.text|e }}</td>
                                        <td>
                                            <?php echo ($phrase->case_sensitive ? 'Yes' : 'No'); ?>
                                        </td>
                                        <td>{{ phrase.Matches|length }}</td>
                                        <td>
                                            {% include "_templates/phrasesOptions.volt" %}
                                        </td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                        </table>

                    </div>

                {% else %}

                    <div class="text-center">
                        There are no phrases available.
                    </div>

                {% endif %}

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#phrase-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>
{% endblock %}

