namespace Business.Models;

public class Organization : Entity
{
    public string Description { get; set; }

    public IEnumerable<Seller> Sellers { get; set; }

    public IEnumerable<Category> Categories { get; set; }
}