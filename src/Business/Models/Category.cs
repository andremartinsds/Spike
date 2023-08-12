namespace Business.Models;

public class Category : Entity
{
    public string Name { get; set; }

    public string Description { get; set; }

    public Guid OrganizationId { get; set; }

    public Organization Organization { get; set; }

    public Seller Seller { get; set; }

    public Guid SellerId { get; set; }
}