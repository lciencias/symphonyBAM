var BASE_TICKET = 1;
var TICKET = 2;
var TICKET_CLIENT = 3;
tinymce.create('tinymce.plugins.ExamplePlugin', {
    createControl: function(n, cm) {
        switch (n) {
            case 'mylistbox':
                var mlb = cm.createListBox('mylistbox', {
                     title : 'Field',
                     onselect : function(v) {
                    	 tinyMCE.execCommand('mceInsertContent',false,v);return false;
                     }
                });

                // Add some values to the list box
                if (kindOfTicket == TICKET){
                	mlb.add(I18n._('Employee'), '%employee.fullname%');
                	mlb.add(I18n._('Priority'), '%priority.name%');
                	mlb.add(I18n._('Impact'), '%impact.name%');
                	mlb.add(I18n._('Channel'), '%channel.name%');
                	mlb.add(I18n._('Company'), '%company.name%');
                	mlb.add(I18n._('Category'), '%category.name%');
                }
                if (kindOfTicket == TICKET_CLIENT){
                	mlb.add(I18n._('Folio'), '%ticket.folio%');
                	mlb.add(I18n._('Reported Branch'), '%reported_branch.name%');
                	mlb.add(I18n._('Origin Branch'), '%origin_branch.name%');
                }
                
                mlb.add(I18n._('# Ticket'), '%ticket.id_ticket_client%');
                mlb.add(I18n._('Registered By User'), '%user.fullname%');
                mlb.add(I18n._('Ticket Created Date'), '%ticket.created%');
                mlb.add(I18n._('Ticket Scheduled Date'), '%ticket.scheduled_date%');
                mlb.add(I18n._('Ticket Type'), '%ticket_type.name%');
                mlb.add(I18n._('Status'), '%ticket.status_name%');
                mlb.add(I18n._('Description'), '%ticket.description%');
                mlb.add(I18n._('Group'), '%group.name%');
                mlb.add(I18n._('Assigned User'), '%assignedUser.fullname%');
                
                mlb.add(I18n._('Expiration Date'), '%info.expirationDate%');
                mlb.add(I18n._('Expired Time: '), '%info.expiredTime%');
                mlb.add(I18n._('Percentage of Service:'), '%info.percentageService%');
                // Return the new listbox instance
                return mlb;
       }

        return null;
    }
});

// Register plugin with a short name
tinymce.PluginManager.add('example', tinymce.plugins.ExamplePlugin);


