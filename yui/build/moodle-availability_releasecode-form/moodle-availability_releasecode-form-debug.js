YUI.add('moodle-availability_releasecode-form', function (Y, NAME) {

/**
 * JavaScript for form editing release code conditions.
 *
 * @module moodle-availability_releasecode-form
 */
M.availability_releasecode = M.availability_releasecode || {};

/**
 * @class M.availability_releasecode.form
 * @extends M.core_availability.plugin
 */
M.availability_releasecode.form = Y.Object(M.core_availability.plugin);

/**
 * If we have added our event listeners or not.
 * @type {boolean}
 */
M.availability_releasecode.form.addedEvents = false;

/**
 * YUI Object
 * @type {Y}
 */
M.availability_releasecode.form.Y = Y;

M.availability_releasecode.form.getNode = function(json) {
    // Create HTML structure.
    var node = Y.Node.create(
        '<span><span class="availability-group"><label>' +
        M.str.availability_releasecode.title +
        ' <input name="value" type="text" /></label></span></span>'
    );

    // Set initial values if specified.
    if (json.rc) {
        node.one('input[name=value]').set('value', json.rc);
    }

    // Add event handlers (first time only).
    if (!M.availability_releasecode.form.addedEvents) {
        M.availability_releasecode.form.addedEvents = true;
        Y.one('#fitem_id_availabilityconditionsjson').delegate('valuechange', function() {
            M.core_availability.form.update();
        }, '.availability_releasecode input[name=value]');
    }

    return node;
};

M.availability_releasecode.form.fillValue = function(value, node) {
    var Y    = M.availability_releasecode.form.Y;
    value.rc = Y.Lang.trim(node.one('input[name=value]').get('value'));
};

M.availability_releasecode.form.fillErrors = function(errors, node) {
    var value = {};
    this.fillValue(value, node);

    // Check release code is not empty.
    if (!value.rc) {
        errors.push('availability_releasecode:error_setvalue');
    }
};


}, '@VERSION@', {"requires": ["base", "node", "event", "event-valuechange", "moodle-core_availability-form"]});
