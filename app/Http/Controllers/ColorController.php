<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Scarf;
use App\Models\Color;
use Spatie\Color\Hex;


class ColorController extends Controller
{
  public function colorPick()
  {
    return view("color.nearest_color");
  }

  public function nearestScarves(Request $request)
  {
    $request->validate([
      'hex' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ]);

    $hex = $request->hex;
    $labInput = $this->hexToLab($hex);

    $scarves = Product::with('color')->whereNotNull('color_id')->get();
    $results = [];

    foreach ($scarves as $scarf) {
      if (!$scarf->color)
        continue;

      if (
        is_null($scarf->color->lab_l) ||
        is_null($scarf->color->lab_a) ||
        is_null($scarf->color->lab_b)
      )
        continue;

      $delta = $this->deltaE2000(
        ['L' => $labInput['L'], 'a' => $labInput['a'], 'b' => $labInput['b']],
        [
          'L' => $scarf->color->lab_l,
          'a' => $scarf->color->lab_a,
          'b' => $scarf->color->lab_b
        ]
      );

      if ($delta > 22)
        continue;

      $results[] = [
        'id' => $scarf->id,
        'name' => $scarf->name,
        'image_url' => $scarf->image,
        'color_name' => $scarf->color->name,
        'color_hex' => $scarf->color->hex,
        'delta' => $delta,   // ✅ مهم جدًا
      ];
    }

    if (empty($results)) {
      return response()->json([]);
    }

    usort($results, fn($x, $y) => $x['delta'] <=> $y['delta']);

    return response()->json(array_slice($results, 0, 10));
  }


  // ... (باقي الدوال الخاصة بالـ DeltaE و hexToLab صحيحة)

  private function deltaE2000($lab1, $lab2)
  {
    // Convert arrays
    $L1 = $lab1['L'];
    $a1 = $lab1['a'];
    $b1 = $lab1['b'];

    $L2 = $lab2['L'];
    $a2 = $lab2['a'];
    $b2 = $lab2['b'];

    $avgLp = ($L1 + $L2) / 2;
    $C1 = sqrt(pow($a1, 2) + pow($b1, 2));
    $C2 = sqrt(pow($a2, 2) + pow($b2, 2));
    $avgC = ($C1 + $C2) / 2;

    $G = 0.5 * (1 - sqrt(pow($avgC, 7) / (pow($avgC, 7) + pow(25, 7))));

    $a1p = (1 + $G) * $a1;
    $a2p = (1 + $G) * $a2;

    $C1p = sqrt(pow($a1p, 2) + pow($b1, 2));
    $C2p = sqrt(pow($a2p, 2) + pow($b2, 2));

    $avgCp = ($C1p + $C2p) / 2;

    $h1p = atan2($b1, $a1p);
    if ($h1p < 0)
      $h1p += 2 * M_PI;

    $h2p = atan2($b2, $a2p);
    if ($h2p < 0)
      $h2p += 2 * M_PI;

    $avgHp = abs($h1p - $h2p) > M_PI
      ? ($h1p + $h2p + 2 * M_PI) / 2
      : ($h1p + $h2p) / 2;

    $T = 1
      - 0.17 * cos($avgHp - M_PI / 6)
      + 0.24 * cos(2 * $avgHp)
      + 0.32 * cos(3 * $avgHp + M_PI / 30)
      - 0.20 * cos(4 * $avgHp - 63 * M_PI / 180);

    $dHp = $h2p - $h1p;
    if (abs($dHp) > M_PI) {
      $dHp += ($dHp > 0) ? -2 * M_PI : 2 * M_PI;
    }

    $dLp = $L2 - $L1;
    $dCp = $C2p - $C1p;
    $dHp = 2 * sqrt($C1p * $C2p) * sin($dHp / 2);

    $Sl = 1 + 0.015 * pow($avgLp - 50, 2) /
      sqrt(20 + pow($avgLp - 50, 2));

    $Sc = 1 + 0.045 * $avgCp;
    $Sh = 1 + 0.015 * $avgCp * $T;

    $deltaTheta = 30 * M_PI / 180 * exp(-pow(($avgHp * 180 / M_PI - 275) / 25, 2));
    $Rc = 2 * sqrt(pow($avgCp, 7) / (pow($avgCp, 7) + pow(25, 7)));
    $Rt = -$Rc * sin(2 * $deltaTheta);

    $kl = $kc = $kh = 1;

    $deltaE = sqrt(
      pow($dLp / ($kl * $Sl), 2) +
        pow($dCp / ($kc * $Sc), 2) +
        pow($dHp / ($kh * $Sh), 2) +
        $Rt * ($dCp / ($kc * $Sc)) * ($dHp / ($kh * $Sh))
    );

    return $deltaE;
  }

  private function hexToLab(string $hex): array
  {
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = $r / 255;
    $g = $g / 255;
    $b = $b / 255;
    $r = ($r > 0.04045) ? pow(($r + 0.055) / 1.055, 2.4) : $r / 12.92;
    $g = ($g > 0.04045) ? pow(($g + 0.055) / 1.055, 2.4) : $g / 12.92;
    $b = ($b > 0.04045) ? pow(($b + 0.055) / 1.055, 2.4) : $b / 12.92;

    $x = $r * 0.4124 + $g * 0.3576 + $b * 0.1805;
    $y = $r * 0.2126 + $g * 0.7152 + $b * 0.0722;
    $z = $r * 0.0193 + $g * 0.1192 + $b * 0.9505;

    $xr = $x / 0.95047;
    $yr = $y / 1.00000;
    $zr = $z / 1.08883;

    $fx = ($xr > 0.008856) ? pow($xr, 1 / 3) : (7.787 * $xr) + 16 / 116;
    $fy = ($yr > 0.008856) ? pow($yr, 1 / 3) : (7.787 * $yr) + 16 / 116;
    $fz = ($zr > 0.008856) ? pow($zr, 1 / 3) : (7.787 * $zr) + 16 / 116;

    $L = (116 * $fy) - 16;
    $a = 500 * ($fx - $fy);
    $b = 200 * ($fy - $fz);

    return ['L' => $L, 'a' => $a, 'b' => $b];
  }

  public function create()
  {
    return view('admin.3d-models-color.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'hex' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ]);
    $file = $request->file('model_3d');
    $filename = time() . '.' . $file->getClientOriginalExtension();

    $file->move(public_path('models'), $filename);
    $hex = $request->input('hex');
    $name = $request->input('name');

    $lab = $this->hexToLab($hex);

    Color::create([
      'name' => $name,
      'hex' => $hex,
      'lab_l' => $lab['L'],
      'lab_a' => $lab['a'],
      'lab_b' => $lab['b'],
      'model_3d' => $filename
    ]);

    return redirect()->back()->with('success', 'Model-Color added successfully!');
  }
}
