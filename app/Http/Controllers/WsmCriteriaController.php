<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WsmCriteriaController extends Controller
{
    public function index(): View
    {
        $criteria = EvaluationCriteria::query()->orderBy('id', 'asc')->get();

        return view('wsm_criteria.index', compact('criteria'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'criteria' => ['required', 'array'],
            'criteria.*.bobot' => ['required', 'numeric', 'min:0'],
        ]);

        foreach (EvaluationCriteria::all() as $criterion) {
            if (isset($data['criteria'][$criterion->id]['bobot'])) {
                $criterion->bobot = $data['criteria'][$criterion->id]['bobot'];
                $criterion->save();
            }
        }

        return redirect()->route('wsm-criteria.index')->with('success', 'Bobot kriteria berhasil diperbarui.');
    }
}
