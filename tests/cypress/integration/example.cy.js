describe("Example Test", () => {
    it("shows a homepage", () => {
        cy.visit("/blog/parallel-php");
        cy.contains("712");
        cy.get("button").click();
        cy.contains("713");
        cy.get("button").click();
        cy.contains("712");
    });
});
