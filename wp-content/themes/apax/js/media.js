(function() {
    var _AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay;
    wp.media.view.Settings.AttachmentDisplay = _AttachmentDisplay.extend({
        render: function() {
            _AttachmentDisplay.prototype.render.apply(this, arguments);
            this.$el.find('select.link-to').val('none').find("option[value=post]").remove();
            this.model.set('link', 'none');
            this.updateLinkTo();
        }
    });
})();
