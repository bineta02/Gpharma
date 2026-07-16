<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Récupère les logs du plus récent au plus ancien avec les infos de l'utilisateur
        $logs = ActivityLog::with('user')->latest()->get();
        return view('logs.index', compact('logs'));
    }
}