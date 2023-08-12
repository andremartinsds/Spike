using Business.Models;
using Microsoft.EntityFrameworkCore;

namespace Data.Context;

public class DataDbContext : DbContext
{
    public DataDbContext(DbContextOptions options) : base(options)
    {
        ChangeTracker.QueryTrackingBehavior = QueryTrackingBehavior.NoTracking;
        ChangeTracker.AutoDetectChangesEnabled = false;
    }

    public DbSet<Organization> Organizations { get; set; }
    public DbSet<Seller> Sellers { get; set; }
    public DbSet<Category> Categories { get; set; }

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.ApplyConfigurationsFromAssembly(typeof(DataDbContext).Assembly);
        base.OnModelCreating(modelBuilder);
    }
}