var ProfileCountries = function () {

    var handleTwitterTypeahead = function() {

        var countries = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          prefetch: {
            url: '/js/pages/typeahead_countries.json',
            filter: function(list) {
              return $.map(list, function(country) { return { name: country }; });
            }
          }
        });
 
        countries.initialize();
         
        $('#UserCountry').typeahead(null, {
          name: 'UserCountry',
          displayKey: 'name',
          hint: true,
          source: countries.ttAdapter()
        });

    }

    return {
        init: function () {
            handleTwitterTypeahead();
        }
    };

}();