{% extends "_templates/dashboard.volt" %}
{% block body_attributes %} id="dashboard"{% endblock %}
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
                        Dashboard
                    </div>


                    <div class="period-select hidden-xs">
                        <form class="input-daterange">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar-o"></i>
                                </span>
                                <input name="start" type="text" class="form-control datepicker" value="{{ firstDoM }}" placeholder="{{ firstDoM }}" />
                            </div>

                            <p class="pull-left">to</p>

                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar-o"></i>
                                </span>
                                <input name="end" type="text" class="form-control datepicker" value="{{ today }}" placeholder="{{ today }}" />
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="metrics clearfix">
                        <div class="metric">
                            <span class="field">Documents</span>
                            <span class="data">{{ statistics['periodPdfs_count'] }}</span>
                        </div>
                        <div class="metric">
                            <span class="field">Phrases</span>
                            <span class="data">{{ statistics['periodPhrasesFound_count'] }}</span>
                        </div>
                        <div class="metric">
                            <span class="field">Total Documents</span>
                            <span class="data">{{ statistics['totalPdfs_count'] }}</span>
                        </div>
                        <div class="metric">
                            <span class="field">Councils</span>
                            <span class="data">{{ statistics['totalCouncils_count'] }}</span>
                        </div>
                    </div>

                    <div class="chart">
                        <h3>
                            Documents Crawled

                            <div class="total pull-right hidden-xs">
                                {{ statistics['periodPdfs_count'] }} total

                                <div class="change up">
                                    <i class="fa fa-chevron-up"></i>
                                    10%
                                </div>
                            </div>
                        </h3>
                        <div id="pdf-crawl-chart"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="chart">
                                <h3>
                                    Recent Activity

                                    <div class="total pull-right hidden-xs">
                                        <a href="">View Feed</a>
                                    </div>
                                </h3>
                                <div class="users-list">
                                    <div class="row headers">
                                        <div class="col-sm-4 header hidden-xs">
                                            <label>Council</label>
                                        </div>
                                        <div class="col-sm-5 header hidden-xs">
                                            <label>Pdf</label>
                                        </div>
                                        <div class="col-sm-3 header hidden-xs">
                                            <label>Phrases</label>
                                        </div>
                                    </div>
                                    {% for pdf in pdfs %}
                                        <div class="row user">
                                            <div class="col-sm-4">
                                                <strong>{{ pdf.ScrapeSource.name }}</strong>
                                            </div>
                                            <div class="col-sm-5">
                                                <a href="{{ url('pdfs/view?id=' ~ pdf.id) }}">{{ pdf.getFileName() }}</a>
                                            </div>
                                            <div class="col-sm-3">
                                                {{ pdf.matches.count() }} phrases
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="chart">
                                <h3>
                                    Top Sources

                                    <div class="total pull-right hidden-xs">
                                        {{ statistics['periodPdfs_count'] }} total

                                        <div class="change down">
                                            <i class="fa fa-chevron-down"></i>
                                            3.5%
                                        </div>
                                    </div>
                                </h3>
                                <div class="referrals">
                                    {% for source in statistics['periodScrapeSources'] %}
                                        <div class="referral">
                                            <span>
                                                {{ source.name}}

                                                <div class="pull-right">
                                                    <span class="data">{{ source.count }}</span>  {{ round(source.count / statistics['periodPdfs_count'] * 100,2) }}%
                                                </div>
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ round(source.count / statistics['periodPdfs_count'] * 100,2) }}%">
                                                </div>
                                            </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
{% endblock %}

{% block chart_data %}
    var chart_data = [{% for pdf in statistics['periodPdfs'] %}
    {% if !loop.last %}
        ["{{ date('Y-m-d', strtotime(pdf.last_checked)) }}", 1],
    {% endif %}
    {% if loop.last %}
        ["{{ date('Y-m-d', strtotime(pdf.last_checked)) }}", 1]
    {% endif %}
    {% endfor %}
        ];

        d = chart_data.reduce(function(acc_data, row) {
        if (!acc_data.hasOwnProperty(row[0])) {
        acc_data[row[0]] = 0;
        }
        acc_data[row[0]]++;
        return acc_data;
        }, {})

        d = Object.keys(d).map(function(da) {
        return [utils.get_timestamp_by_date(da), d[da]];
        });

        {% endblock %}