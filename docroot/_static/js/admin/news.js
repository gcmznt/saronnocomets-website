$(function(){


});


$(function(){

    var News = Backbone.Model.extend({
    });

    var ListaNews = Backbone.Collection.extend({
        model: News,
        url: 'data/',
        initialize: function() {
            this.bind('reset', this.addAll, this);
            this.fetch();
        },
        addOne: function(News) {
            var view = new NewsView({model: News});
            this.$("table tbody").append(view.render().el);
        },
        addAll: function() {
            this.each(this.addOne);
        }
    });

    var NewsView = Backbone.View.extend({
        tagName: "tr",
        template: _.template($('#news-template').html()),
        initialize: function() {
        },
        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }

    });

    var listaNews = new ListaNews;

});
