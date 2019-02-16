{% extends "_templates/basic.volt" %}
{% block body %}

    <div id="wrapper">
        {% include "_templates/navigation.volt" %}

        <div id="content">

            <div class="panel">

                <div class="menubar">
                    <div class="sidebar-toggler visible-xs">
                        <i class="ion-navicon"></i>
                    </div>

                    <div class="page-title">
                        Management
                    </div>
                </div>

                <div class="content-wrapper">

                    {% include "_templates/flashMessages.volt" %}

                    <div class="row">

                        <div class="col-lg-6">
                            {% include "_templates/scrapeSourceForm.volt" %}
                            {% include "_templates/phraseForm.volt" %}
                        </div>

                        <div class="col-lg-6">

                            {% include "_templates/scrapeUrlForm.volt" %}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

{% endblock %}


