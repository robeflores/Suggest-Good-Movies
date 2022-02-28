namespace BlazorApp.Data;
using System.ComponentModel.DataAnnotations;

public class FiltersModel
{
    [Required]
    [StringLength(4, MinimumLength = 4, ErrorMessage = "year must be in the format YYYY.")]
    public string? since { get; set; }//1874-current year

    [Required]
    [StringLength(4, MinimumLength = 4, ErrorMessage = "year must be in the format YYYY.")]
    public string? until { get; set; }
}