$(function(){

    $('#tournamentTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#tournamentTabs a:first').tab('show');

});


$(function(){

    var Squadra = Backbone.Model.extend({
    });

    var Squadre = Backbone.Collection.extend({
        model: Squadra,
        url: 'data/',
        initialize: function() {
            this.bind('reset', this.addAll, this);
            this.fetch();
        },
        addOne: function(Squadra) {
            var view = new SquadraView({model: Squadra});
            this.$("#" + Squadra.get('tournament') + "Table tbody").append(view.render().el);
        },
        addAll: function() {
            this.each(this.addOne);
        }
    });

    var SquadraView = Backbone.View.extend({
        tagName: "tr",
        template: _.template($('#team-template').html()),
        initialize: function() {
        },
        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }

    });

    var listaSquadre = new Squadre;

});
