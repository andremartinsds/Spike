using Business.Models;

namespace Data.Test;

public class BuilderCategory
{
    public static IEnumerable<Category> ListCategories()
    {
        var categories = new List<Category>();

        var org = new Organization();
        org.Description = "Org description";

        var seller = new Seller();
        seller.Description = "seller description";
        seller.Organization = org;
        seller.OrganizationId = org.Id;

        var sellersOrg = new List<Seller>();
        sellersOrg.Add(seller);

        categories.Add(
            new Category
            {
                Name = "Biscoito",
                Description = "Lanches e outros",
                OrganizationId = org.Id,
                Organization = org,
                Seller = seller,
                SellerId = seller.Id
            }
        );

        categories.Add(new Category
        {
            Name = "Carnes",
            Description = "Lanches e outros",
            OrganizationId = org.Id,
            Organization = org,
            Seller = seller,
            SellerId = seller.Id
        });

        return categories;
    }
}