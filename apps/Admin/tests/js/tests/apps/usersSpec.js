describe('Users App', function() {
 
  describe('Index', function() {
 
    beforeEach(function() {
      
    });
 
 
    it('should ', function() {

    	var projects = ListCtrl.projects;
    	var resolvedValue;
    	projects.then(function(pr) { resolvedValue = pr});
    	httpBackend.flush();
    	$rootScope.$apply()
    	expect(sanitizeRestangularAll(resolvedValue)).toEqual('[{"name":"tester"},{"name":"tester2"}]');

    });
  });
});