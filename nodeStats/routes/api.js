/*
 * Serve JSON to our AngularJS client
 */

exports.details = function (req, res) {
  res.json({
    name: 'Lucian',
    job: "garbage man"
  });
};