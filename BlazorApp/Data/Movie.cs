namespace BlazorApp.Data;

public class Movie{
    public string? title { get; set; }
    public string? year { get; set; }
    public string? genres { get; set; }
    public string? rating { get; set; }
    public string? description { get; set; }
    public string? link { get; set; }

    public Movie(string title, string year, string genres, string rating, string description) {
        this.title = title;
        this.year = year;
        this.genres = genres;
        this.rating = rating;
        this.description = description;
    }
}

