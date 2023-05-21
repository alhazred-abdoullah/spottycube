describe('auth spec', () => {
  it('login to the app', () => {
    cy.visit('http://localhost/login');
    cy.get('input[name="email"]').type('admin@example.com');
    cy.get('input[name="password"]').type('password');
    cy.get('button[type="submit"]').click();
    cy.contains('Hello');
  })
})
