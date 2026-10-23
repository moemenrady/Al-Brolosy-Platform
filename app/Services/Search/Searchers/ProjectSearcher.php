<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectPaymentPlan;
use App\Models\ProjectUnitType;
use App\Models\Tag;
use Illuminate\Support\Arr;

final class ProjectSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        $projects = [];

        // Collect project ids from different domain searches with their score
        $scores = [];

        if ($keyword) {
            $kw = "%{$keyword}%";

            // Project name (100)
            $ids = Project::where('is_active', true)
                ->where(function ($q) use ($kw) {
                    $q->where('name_ar', 'like', $kw)
                        ->orWhere('name_en', 'like', $kw);
                })->pluck('id')->all();
            foreach ($ids as $id) {
                $scores[$id] = max($scores[$id] ?? 0, 100);
            }

            // Project description/location (70)
            $ids = Project::where('is_active', true)
                ->where(function ($q) use ($kw) {
                    $q->where('description_ar', 'like', $kw)
                        ->orWhere('description_en', 'like', $kw)
                        ->orWhere('location_ar', 'like', $kw)
                        ->orWhere('location_en', 'like', $kw);
                })->pluck('id')->all();
            foreach ($ids as $id) {
                $scores[$id] = max($scores[$id] ?? 0, 70);
            }

            // Tags (80)
            $tagIds = Tag::where('name', 'like', $kw)->pluck('id')->all();
            if (!empty($tagIds)) {
                $projIds = Project::whereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds))->pluck('id')->all();
                foreach ($projIds as $id) {
                    $scores[$id] = max($scores[$id] ?? 0, 80);
                }
            }

            // Features (75)
            $featIds = ProjectFeature::where('title_ar', 'like', $kw)
                ->orWhere('title_en', 'like', $kw)
                ->orWhere('value', 'like', $kw)
                ->pluck('project_id')->all();
            foreach ($featIds as $id) {
                $scores[$id] = max($scores[$id] ?? 0, 75);
            }

            // Unit Types (85)
            $unitTypeProjIds = ProjectUnitType::where('unit_type', 'like', $kw)
                ->orWhere('finishing_type', 'like', $kw)
                ->pluck('project_id')->all();
            foreach ($unitTypeProjIds as $id) {
                $scores[$id] = max($scores[$id] ?? 0, 85);
            }

            // Payment plans (45)
            $planProjIds = ProjectPaymentPlan::where('down_payment', 'like', $kw)
                ->orWhere('installment_years', 'like', $kw)
                ->orWhere('maintenance', 'like', $kw)
                ->orWhere('notes', 'like', $kw)
                ->pluck('project_id')->all();
            foreach ($planProjIds as $id) {
                $scores[$id] = max($scores[$id] ?? 0, 45);
            }
        }

        // If no keyword but filters present, fetch projects matching filters with low score
        if (empty($scores)) {
            $query = Project::query()->where('is_active', true);

            if (isset($filters['sector'])) {
                $query->where('sector_id', $filters['sector']);
            }
            if (isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }
            if (isset($filters['featured'])) {
                $query->where('featured', (bool) $filters['featured']);
            }
            if (isset($filters['delivery_time'])) {
                $query->where('delivery_time', $filters['delivery_time']);
            }
            if (isset($filters['budget'])) {
                $query->where('price_budget', '<=', $filters['budget']);
            }

            $projList = $query->with('images')->limit(50)->get();
            foreach ($projList as $p) {
                $scores[$p->id] = max($scores[$p->id] ?? 0, 10);
            }
        }

        if (empty($scores)) {
            return [];
        }

        $projectIds = array_keys($scores);

        $models = Project::with(['images', 'sector'])
            ->whereIn('id', $projectIds)
            ->get()
            ->keyBy('id');

        $results = [];
        foreach ($scores as $id => $score) {
            $p = $models->get($id);
            if (! $p) {
                continue;
            }

            $image = $p->image ?: ($p->images->first()->image ?? null);

            $results[] = new SearchResult(
                id: $p->id,
                type: 'project',
                title: $p->name_en ?? $p->name_ar,
                subtitle: $p->sector?->getNameAttribute() ?? null,
                description: $p->description,
                image: $image,
                url: route('projects.show', $p->id),
                icon: 'building',
                badge: 'Project',
                score: (int) $score,
                metadata: [
                    'status' => $p->status,
                ]
            );
        }

        return $results;
    }
}
