<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class RaceController extends Controller
{
    private $filePath = 'races.json';

    private function getRacesFromFile()
    {
        if (Storage::exists($this->filePath)) {
            return json_decode(Storage::get($this->filePath), true);
        }
        return [];
    }

    private function saveRacesToFile(array $races)
    {
        Storage::put($this->filePath, json_encode($races));
    }

    public function index()
    {
        $races = $this->getRacesFromFile();
        return view('races.index', compact('races'));
    }

    public function create()
    {
        return view('races.create');
    }

    public function store(Request $request)
    {
        $students = $request->input('students');
        $lanes = $request->input('lanes');
        $studentsWithLanes = [];
        foreach ($students as $index => $student) {
            $studentsWithLanes[] = ['name' => $student, 'lane' => $lanes[$index]];
        }
        $race = ['students' => $studentsWithLanes, 'results' => []];
        $races = $this->getRacesFromFile();
        $races[] = $race;
        $this->saveRacesToFile($races);
        return redirect()->route('races.index');
    }

    public function edit($raceId)
    {
        $races = $this->getRacesFromFile();
        $race = $races[$raceId];
        return view('races.edit', compact('race', 'raceId'));
    }

    public function update(Request $request, $raceId)
    {
        $races = $this->getRacesFromFile();
        $race = $races[$raceId];
        foreach ($race['students'] as &$student) {
            $student['lane'] = $request->input('lane_'.$student['name']);
            $race['results'][$student['name']] = $request->input($student['name']);
        }

        $races[$raceId] = $race;
        $this->saveRacesToFile($races);
        return redirect()->route('races.index');
    }

    public function destroy($raceId)
    {
        $races = $this->getRacesFromFile();
        unset($races[$raceId]);
        $races = array_values($races);
        $this->saveRacesToFile($races);
        return redirect()->route('races.index')->with('success', 'Race deleted successfully.');
    }

    public function downloadPdf($raceId)
    {
        $races = $this->getRacesFromFile();
        $race = $races[$raceId];
        $pdf = Pdf::loadView('races.pdf', compact('race'));
        return $pdf->download('race_results.pdf');
    }

    public function exportAllRacesPdf()
    {
        $races = $this->getRacesFromFile();
        $pdf = Pdf::loadView('races.all-races-pdf', compact('races'));
        return $pdf->download('all_races_results.pdf');
    }
}
