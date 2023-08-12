using Business.Models;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata.Builders;

namespace Data.Mappings;

public class SellerMapping : IEntityTypeConfiguration<Seller>
{
    public void Configure(EntityTypeBuilder<Seller> builder)
    {
        builder.HasKey(s => s.Id);
        builder.Property(s => s.Description).IsRequired().HasColumnType("varchar(100)");
        builder.HasOne(s => s.Organization).WithMany(o => o.Sellers);
        builder.HasMany(e => e.Categories).WithOne(c => c.Seller);

        builder.ToTable("Sellers");
    }
}