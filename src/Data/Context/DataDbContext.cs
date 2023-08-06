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

    public DbSet<Category> Categories { get; set; }

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.ApplyConfigurationsFromAssembly(typeof(DataDbContext).Assembly);
        base.OnModelCreating(modelBuilder);
    }
}