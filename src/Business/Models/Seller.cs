namespace Business.Models;

public class Seller : Entity
{
    public string Description { get; set; }

    public Guid OrganizationId { get; set; }

    public Organization Organization { get; set; }

    public IEnumerable<Category> Categories { get; set; }
}