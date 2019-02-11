A mediawiki extension renders latex and mml equations in between `<math></math>`, using mathtype, and it's inspired by [SimpleMathJax](https://github.com/jmnote/SimpleMathJax).

# Installation
1. Git clone this repo in mediawiki extensions directory.
```Bash
$ git clone https://github.com/ahmadnourallah/MathRenderer.git
```

2. Load the extension in your *LocalSetting.php* file.
```PHP
wfLoadExtension( 'MathRenderer' );
```

# Usage

Put the equation you need inside a `math` tag in your mediawiki article. You can use the [MathType SDK Editor](http://www.wiris.net/demo/editor/tests/ar/test.html) for visual editing equations.

Example:
```HTML
<math>a+b</math>
```

# Optional Settings
| Setting name           | Default value                                          | Description                                   |
| ---------------------  | ------------------------------------------------------ | --------------------------------------------- |
| `$wgMRUseMML`          | `false`                                                 | The default equations are mml or latex (mml if true, otherwise latex)?       |
| `$wgMRMathTypeService` | `//www.wiris.net/demo/editor/render`                   | The MathType renderer service                 |
| `$wgMROptions`         | `array("fontFamily" => "Arial", "fontSize" => 16, "color" => "black", "backgroundColor" => "transparent", "format" => "svg");`     | Rendering options                               |

Options in `$wgMROptions` are the default for all equations. Although, they can be overwritten by writing them in the `math` tag.

Example:
```HTML
<math fontFamily="Amiri" fontSize="20" color="white" backgroundColor = "black">a+b</math>
```

# Latex and MathML

Although the default type of equations is determined by the `$wgMRUseMML`, you can use a specific type by including `mml=true` or `latex=true` attributes in the `math` tag.

Example:
```HTML
<math latex="true">a+b</math>
```

# Display and Inline modes

In the display mode, equations are rendered in the center of the page, whereas in the inline mode equations are rendered in between the page content.
These two modes can be specified using `mode` attribute.

Example:
```HTML
<math latex="true" mode="display">a+b</math>
```